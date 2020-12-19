<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 11:33 AM
 */

namespace bk\phpmvcfw\middlewares;


/**
 * Class BaseMiddleware
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}