<?php
/**
 * User: ifelsetalents
 * Date: 7/8/2020
 * Time: 8:43 AM
 */

namespace bk\phpmvcfw;




/**
 * Class Model
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package app\models
 */

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public const RULE_UNIQUE = 'unique';

    public function loadData($data) {
        foreach($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract function rules(): array;

    public function labels()
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public array $errors = [];

    public function validate() {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            //echo var_dump($attribute);
            foreach ($rules as $rule) {
                $ruleName = $rule;
                
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                //echo var_dump($rule);
            
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("select * from $tableName where $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record) {
                        //$this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
         return empty($this->errors);
    }

    //we add in last params to replace min and max placeholder by theres values
    //public function addErrorForRule(string $attribute, string $rule, $params = []){
    private function addErrorForRule(string $attribute, string $rule, $params = []){
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message){
        
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return  [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email',
            self::RULE_MIN => 'Min lenthg of this field must be {min}',
            self::RULE_MAX => 'Max lenthg of this field must be {max}',
            self::RULE_MATCH => 'This field must be same as {match}',
            self::RULE_UNIQUE => 'This {field} already existe must be unique'
        ];
    }

    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirtsError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }
    

}