<?php

namespace App\Models;

use App\Core\Model;

class RegisterModel extends Model
{
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $password = '';
    public $confirmPassword = '';

    public function register(){
        return "Creating new user";
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
}