<?php

namespace App\Core;

class Controller
{
    public $layout = 'main';

    protected function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }
    protected function setLayout($layout){
        $this->layout = $layout;
    }
}