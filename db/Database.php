<?php
/**
 * User: ifelsetalents
 * Date: 7/10/2020
 * Time: 8:09 AM
 */

namespace bk\phpmvcfw\db;
use bk\phpmvcfw\Application;



/**
 * Class Database
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw\db;
 */
class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dbDsn = $config['dsn'] ?? '';
        $username = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dbDsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigration() {
        $this->createMigrationTable();
        $applieMigrations = $this->getAppliedMigrations();

        $newMigrations = [];

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        //echo '<pre>'; var_dump($files); echo '</pre>';
        $migrationsToApply = array_diff($files, $applieMigrations);
        //echo '<pre>'; var_dump($migrationsToApply); echo '</pre>';
        foreach($migrationsToApply as $migration) {
            if($migration === '.' or $migration === '..') {
                continue;
            }
            require_once(Application::$ROOT_DIR.'/migrations/'.$migration);
            $className = pathinfo($migration, PATHINFO_FILENAME);
            //echo '<pre>'; var_dump($className); echo '</pre>';exit;
            $instance = new $className();
            //echo "applying migration $migration".PHP_EOL;
            $this->log("applying migration $migration");
            $instance->up();
            //echo "applied migration $migration".PHP_EOL;
            $this->log("applied migration $migration");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            //echo "There are no migrations to apply";
            $this->log("There are no migrations to apply");
        }
    }


    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    public function createMigrationTable() {
        $SQL = "CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $this->pdo->exec($SQL);
    }

    public function getAppliedMigrations() {
        $SQL = "SELECT migration FROM migrations";
        $statement = $this->pdo->prepare($SQL);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    protected function saveMigrations(array $newMigrations)
    {
        //echo '<pre>'; var_dump($newMigrations); echo '</pre>';
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        //echo '<pre>'; var_dump($str); echo '</pre>';
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }

    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    

}