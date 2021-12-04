<?php

use App\Controller\AuthController;
use App\Controller\UserController;
use App\Controller\RegisterController;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\Container;
use DI\ContainerBuilder;
use League\Plates\Engine;
use League\Plates\Extension\Asset;

session_start();

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

//Container
$container = new Container();
$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    PDO::class => static function () {
        return new PDO('mysql:host=localhost;dbname=module2exam;charset=utf8', 'admin', 'root');
    },
    QueryFactory::class => static function () {
        return new QueryFactory('mysql');
    },
    Engine::class => static function () {
        return new Engine($_SERVER['DOCUMENT_ROOT'] . '/app/views');
    },
    Asset::class => static function () {
        return new Asset($_SERVER['DOCUMENT_ROOT'] . '/public/');
    },
    Auth::class => static function ($container) {
        return new Auth($container->get('PDO'));
    },
]);
$container = $containerBuilder->build();

//FastRoute
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $rout) {
    $rout->addRoute('GET', '/', [AuthController::class, 'auth']);
    $rout->addRoute('POST', '/', [AuthController::class, 'postAuth']);
    $rout->addRoute('GET', '/register/', [RegisterController::class, 'register']);
    $rout->addRoute('POST', '/register/', [RegisterController::class, 'postRegister']);
    $rout->addRoute('GET', '/users/', [UserController::class, 'users']);
    $rout->addRoute('GET', '/users/{id:[0-9]+}/', [UserController::class, 'users']);
    $rout->addRoute('GET', '/create/', [UserController::class, 'create']);
    $rout->addRoute('POST', '/create/', [UserController::class, 'postCreate']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/', [UserController::class, 'profile']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/edit/', [UserController::class, 'profileEdit']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/edit/', [UserController::class, 'postProfileEdit']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/media/', [UserController::class, 'profileMedia']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/media/', [UserController::class, 'postProfileMedia']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/status/', [UserController::class, 'profileStatus']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/status/', [UserController::class, 'postProfileStatus']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/security/', [UserController::class, 'profileSecurity']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/security/', [UserController::class, 'postProfileSecurity']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/delete/', [UserController::class, 'profileDelete']);
    $rout->addRoute('GET', '/logout/', [UserController::class, 'logout']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'Error404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'Error404';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($handler, [$vars]);
        break;
}
