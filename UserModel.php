<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 10:13 AM
 */

namespace app\core;

use app\core\db\DbModel;

/**
 * Class UserModel
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package thecodeholic\phpmvc
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}