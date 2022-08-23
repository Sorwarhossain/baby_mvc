<?php

namespace App\Core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public $errors = [];

    public function loadData($data){
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validate(){

        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};

            foreach ($rules as $rule){
                $ruleName = $rule;
                if(is_array($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }

                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->database->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);

                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    private function addError($attibute, $ruleName, $params = []){
        $message = $this->errorMessages()[$ruleName];

        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attibute] = $message;
    }

    private function errorMessages(){
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'The {field} already exists in database',
        ];
    }

    public function hasError($attibute){
        return $this->errors[$attibute] ?? false;
    }

    /**
     * @return string
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute] ?? '';
    }
}