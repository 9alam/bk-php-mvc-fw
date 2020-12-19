<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 11:43 AM
 */

namespace app\core\exception;


/**
 * Class NotFoundException
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package app\core\exception
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}