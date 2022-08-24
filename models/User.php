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
            'firstname' => [
                [
                    'rule' => self::RULE_REQUIRED,
                    'message' => 'Firstname is required'
                ]
            ],
            'lastname' => [
                [
                    'rule' => self::RULE_REQUIRED,
                    'message' => 'Lastname is required'
                ]
            ],
            'email' => [
                [
                   'rule' => self::RULE_EMAIL,
                   'message' => 'Pleaes enter a valid email'
                ],
                [
                    'rule' => self::RULE_UNIQUE,
                    'message' => 'This email is already registered',
                    'class' => self::class
                ]
            ],
            'password' => [
                [
                    'rule' => self::RULE_MIN,
                    'message' => 'Minimum password length is 3',
                    'min' => 3
                ]
            ],
            'confirmPassword' => [
                [
                    'rule' => self::RULE_MATCH,
                    'message' => 'Password didn\'t matched',
                    'match' => 'password'
                ]
            ]
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