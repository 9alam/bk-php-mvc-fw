<?php
/**
 * User: TheCodeholic
 * Date: 7/26/2020
 * Time: 3:49 PM
 */

namespace bk\phpmvcfw\form;


use bk\phpmvcfw\Model;

/**
 * Class BaseField
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package thecodeholic\phpmvc\form
 */
abstract class BaseField
{

    public Model $model;
    public string $attribute;
    public string $type;

    /**
     * Field constructor.
     *
     * @param \bk\phpmvcfw\Model $model
     * @param string          $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">%s</div>
            </div>
            ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirtsError($this->attribute)
        );
    }


    abstract public function renderInput();
}