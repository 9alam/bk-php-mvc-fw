<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 11:35 AM
 */

namespace bk\phpmvcfw\exception;


use bk\phpmvcfw\Application;

/**
 * Class ForbiddenException
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}