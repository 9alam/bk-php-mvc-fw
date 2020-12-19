<?php
/**
 * User: ifelsetalents
 * Date: 03/11/2020
 * Time: 10:01 AM
 */

namespace app\core;
use app\core\Application;
use app\core\Request;

/**
 * Class Router
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package app\core
 */


class Response
{
    public function setStatusCode(int $code) {
        http_response_code($code);
    }

    public function redirect(string $url) {
        header('Location:'.$url);
    }
}