<?php

use App\Controller\AuthController;
use App\Controller\ErrorController;
use App\Controller\ProfileController;
use App\Controller\LogoutController;
use App\Controller\RegisterController;
use App\Controller\SecurityController;
use App\Controller\DeleteController;
use App\Controller\StatusController;
use App\Controller\UsersController;
use App\Controller\MediaController;
use App\Controller\СreateController;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\Container;
use DI\ContainerBuilder;
use League\Plates\Engine;
use League\Plates\Extension\Asset;

ini_set('display_errors', 'off');
session_start();

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
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
    //Авторизация
    $rout->addRoute('GET', '/', [AuthController::class, 'auth']);
    $rout->addRoute('POST', '/', [AuthController::class, 'postAuth']);
    //Регистрация
    $rout->addRoute('GET', '/register/', [RegisterController::class, 'register']);
    $rout->addRoute('POST', '/register/', [RegisterController::class, 'postRegister']);
    $rout->addRoute('GET', '/confirm/', [RegisterController::class, 'confirmRegister']);
    //Список пользователей
    $rout->addRoute('GET', '/users/', [UsersController::class, 'users']);
    $rout->addRoute('GET', '/users/{id:[0-9]+}/', [UsersController::class, 'users']);
    //Добавить пользователя
    $rout->addRoute('GET', '/create/', [СreateController::class, 'create']);
    $rout->addRoute('POST', '/create/', [СreateController::class, 'postCreate']);
    //Редактировать пользователя
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/', [ProfileController::class, 'profile']);
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/edit/', [ProfileController::class, 'profileEdit']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/edit/', [ProfileController::class, 'postProfileEdit']);
    //Загрузить аватар
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/media/', [MediaController::class, 'profileMedia']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/media/', [MediaController::class, 'postProfileMediaEdit']);
    //Установить статус
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/status/', [StatusController::class, 'profileStatus']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/status/', [StatusController::class, 'postProfileStatusEdit']);
    //Безопасность
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/security/', [SecurityController::class, 'profileSecurity']);
    $rout->addRoute('POST', '/profile/{id:[0-9]+}/security/', [SecurityController::class, 'postProfileSecurityEdit']);
    //Удалить пользователя
    $rout->addRoute('GET', '/profile/{id:[0-9]+}/delete/', [DeleteController::class, 'profileDelete']);
    //Выход пользователя
    $rout->addRoute('GET', '/logout/', [LogoutController::class, 'logout']);
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
        //Контроллер 404
        $container->call([ErrorController::class, 'pageNotFound'], []);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        //Контроллер 404
        $container->call([ErrorController::class, 'pageNotFound'], []);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        //Контроллер
        $container->call($handler, [$vars]);
        break;
}
