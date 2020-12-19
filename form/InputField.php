<?php
/**
 * User: ifelsetalents
 * Date: 7/8/2020
 * Time: 8:43 AM
 */

namespace bk\phpmvcfw\form;
use bk\phpmvcfw\Model;


/**
 * Class InputField
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
 */

class InputField extends BaseField
{

    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    //public Model $model;
    //public string $attribute;
    public string $type;

    /** 
     * @param \bk\phpmvcfw\Model $model
     * @param string $attribute
     *
     */
    public function __construct(Model $model, string $attribute)
    {
        //$this->model = $model;
        //$this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
        parent::__construct($model,$attribute);
    }

    public function textField() {
        $this->type = self::TYPE_TEXT;
        return $this;
    }
    public function passwordField() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
    public function emailField() {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    // public function __toString()
    // {
    //     //return '1';
    //     return sprintf('
    //         <div class="form-group">
    //             <label>%s</label>
    //             %s
    //             <div class="invalid-feedback">%s</div>
    //         </div>
    //         ',
    //         //$this->attribute,
    //         // $this->model->labels()[$this->attribute] ?? $this->attribute,
    //         $this->model->getLabel($this->attribute),
    //         $this->renderInput(),
    //         // $this->type,
    //         // $this->attribute,
    //         // $this->model->hasError($this->attribute) ? ' is-invalid' : '',
    //         // $this->model->{$this->attribute},
    //         $this->model->getFirtsError($this->attribute)
    //     );
    // }

    public function renderInput()
    {
        return sprintf('<input type="%s" name="%s" class="form-control%s" value="%s">',            
            $this->type,
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute},
        );
    }

}