<?php
/**
 * User: ifelsetalents
 * Date: 7/8/2020
 * Time: 8:43 AM
 */

namespace bk\phpmvcfw\form;

use bk\phpmvcfw\Model;


/**
 * Class Form
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
 */

class Form
{
    public static function begin($action, $method) {
        //return '<form action="" method="">';
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    public static function end() {
        echo '</form>';
    }

    public function field(Model $model, $attribute) {
        return new InputField($model, $attribute);
    }

}