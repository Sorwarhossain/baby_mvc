<?php

namespace App\Core;

use App\Core\Middlewares\BaseMiddleware;

class Controller
{
    public $layout = 'main';
    public string $action = '';
    private $middlewares = [];

    protected function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }
    protected function setLayout($layout){
        $this->layout = $layout;
    }

    protected function registerMiddleware(BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}