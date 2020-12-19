<?php
/**
 * User: ifelsetalents
 * Date: 03/11/2020
 * Time: 10:01 AM
 */

namespace bk\phpmvcfw;
use bk\phpmvcfw\Application;
use bk\phpmvcfw\Request;

/**
 * Class Router
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
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