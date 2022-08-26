<?php

namespace App\Core;

abstract class UserModel extends DBModel
{
    abstract public function getDisplayName();
}