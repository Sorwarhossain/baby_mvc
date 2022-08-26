<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use App\Controllers\SiteController;
use App\Controllers\AuthController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$app = new Application(dirname(__DIR__));

$siteController = new SiteController();
$authController = new AuthController();

$app->router->get('/', [$siteController, 'home']);

$app->router->get('/contact', [$siteController, 'contact']);

$app->router->post('/contact', [$siteController, 'handleContact']);

// Auth Controllers
$app->router->get('/login', [$authController, 'login']);
$app->router->post('/login', [$authController, 'login']);

$app->router->get('/register', [$authController, 'register']);
$app->router->post('/register', [$authController, 'register']);

// This is for test
$app->router->get('/logout', [$authController, 'login']);

$app->run();

