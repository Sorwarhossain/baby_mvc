<?php
namespace App\Core;

use App\Models\User;

class Application {

    public static string $ROO_DIR;

    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public Database $database;
    public static Application $app;
    public $user;

    public function __construct($rootPath)
    {

        $this->userClass = User::class;
        self::$app = $this;
        self::$ROO_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->database = new Database();

        $primaryKey = $this->userClass::primaryKey();
        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }

    }

    public function run(){
        echo $this->router->resolve();
    }

    public function login(DBModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
