<?php
namespace App\Core;

class Application {

    public static string $ROO_DIR;

    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public Database $database;
    public static Application $app;

    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROO_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->database = new Database();
    }

    public function run(){
        echo $this->router->resolve();
    }
}
