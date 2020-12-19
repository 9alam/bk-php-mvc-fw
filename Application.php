<?php
/**
 * User: ifelsetalents
 * Date: 03/11/2020
 * Time: 9:57 AM
 */

namespace bk\phpmvcfw;

use app\models\LoginForm;
use bk\phpmvcfw\db\DbModel;
use bk\phpmvcfw\db\Database;
use bk\phpmvcfw\UserModel;


/**
 * Class Application
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw;
 */

class Application
{
    public Request $request;
    public Router $router;
    public static $ROOT_DIR;
    public Response $response;
    public static Application $app;
    public ?Controller $controller = null;
    public Database $db;
    public Session $session;

    //public ?DbModel $user;
    public ?UserModel $user;
    public string $userClass;

    public View $view;

    public string $layout = 'main';

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();

        $this->view = new View();

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = null;
        }
        

    }


    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            //echo 'error';

            $this->response->setStatusCode($e->getCode());

            echo Application::$app->view->renderView('_error', [
                'exception' => $e,
            ]);
        }
    }



    /**
     * Get the value of controller
     */ 
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set the value of controller
     *
     * @return  self
     */ 
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $value = $user->{$primaryKey};
        Application::$app->session->set('user', $value);

        return true;
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }
}