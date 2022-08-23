<?php

namespace App\Models;

use App\Core\DBModel;

class User extends DBModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $password = '';
    public $confirmPassword = '';
    public $status = self::STATUS_INACTIVE;

    public function save(){

        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_EMAIL],
            'password' => [[self::RULE_MIN, 'min' => 3]],
            'confirmPassword' => [[self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function tableName()
    {
        return 'users';
    }

    public function attributes(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'status',
            'password'
        ];
    }
}