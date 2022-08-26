<?php

namespace App\Models;

use App\Core\Application;
use App\Core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [
                [
                    'rule' => self::RULE_EMAIL,
                    'message' => 'Pleaes enter a valid email'
                ],
            ],
            'password' => [
                [
                    'rule' => self::RULE_REQUIRED,
                    'message' => 'Password is required'
                ]
            ]
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if(!$user){
            $this->addError('email', 'User does not exists with this email');
            return false;
        }

        if(!password_verify($this->password, $user->password)){
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }
}