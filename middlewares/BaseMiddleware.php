<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 11:33 AM
 */

namespace app\core\middlewares;


/**
 * Class BaseMiddleware
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package app\core
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}