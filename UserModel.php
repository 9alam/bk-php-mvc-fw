<?php
/**
 * User: ifelsetalents
 * Date: 7/25/2020
 * Time: 10:13 AM
 */

namespace bk\phpmvcfw;

use bk\phpmvcfw\db\DbModel;

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