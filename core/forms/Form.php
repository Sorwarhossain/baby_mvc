<?php

namespace App\Core\Forms;

use App\Core\Model;

class Form
{
    public $name = 'Saroar';
    public static function begin($action, $method)
    {
        echo '<form class="row g-3" method="'. $method .'" action="'. $action .'">';
        return new Form();
    }

    public static function end()
    {
        return '</form>';
    }

    public function field(Model $model, $attribute, $label = null)
    {
        return new Field($model, $attribute, $label);
    }
}

