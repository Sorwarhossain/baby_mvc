<?php

namespace App\Core\Forms;

use App\Core\Model;

class Field
{
    public Model $model;
    public $attribute;
    public $fieldType;

    public function __construct(Model $model, string $attribute)
    {
        $this->model =$model;
        $this->attribute = $attribute;
        $this->fieldType = 'text';
    }

    public function __toString(){



        $errorClass = $this->model->hasError($this->attribute) ? 'is-invalid' : '';
        $errorMessage = $this->model->getFirstError($this->attribute);

        $output = '';
        $output .= '<div class="form-group">';
        $output .= '<label for="'. $this->attribute .'" class="form-label">'. $this->attribute .'</label>';
        $output .= '<input type="'. $this->fieldType .'" value="'. $this->model->{$this->attribute} .'" class="form-control '. $errorClass .'" id="'. $this->attribute .'" name="'. $this->attribute .'">';
        $output .= '<div class="invalid-feedback">'. $errorMessage .'</div>';
        $output .= '</div>';

        return $output;
    }

    public function fieldType($fieldType){
        $this->fieldType = $fieldType;
        return $this;
    }
}