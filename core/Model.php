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

                $ruleName = $rule['rule'];

                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addFormError($attribute, $rule['message']);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addFormError($attribute, $rule['message']);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addFormError($attribute, $rule['message']);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addFormError($attribute, $rule['message']);
                }

                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $tableName = $className::tableName();

                    $statement = Application::$app->database->prepare("SELECT * FROM $tableName WHERE $attribute = :attr");
                    $statement->bindValue(":attr", $value);

                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        $this->addFormError($attribute, $rule['message']);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function addError($attibute, $message){
        $this->errors[$attibute] = $message;
    }

    private function addFormError($attibute, $message){
        $this->errors[$attibute] = $message;
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