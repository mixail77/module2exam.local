<?php

namespace App\Controller;

use App\Classes\QueryBuilder;
use App\Classes\Redirect;
use App\Classes\Request;
use Delight\Auth\Auth;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use SimpleMail;
use Tamtamchik\SimpleFlash\Flash;

class Controller
{

    public $query;
    public $auth;
    public $engine;
    public $flash;
    public $mail;
    public $redirect;
    public $request;

    public function __construct(
        QueryBuilder $query,
        Auth         $auth,
        Engine       $engine,
        Asset        $asset,
        Flash        $flash,
        SimpleMail   $mail,
        Redirect     $redirect,
        Request      $request
    )
    {

        $this->query = $query;
        $this->mail = $mail;
        $this->auth = $auth;
        $this->engine = $engine;
        $this->flash = $flash;
        $this->redirect = $redirect;
        $this->request = $request;

        $this->engine->loadExtension($asset);

    }

    /**
     * Проверяет авторизацию пользователя
     * @return bool
     */
    public function isAuth()
    {

        if ($this->auth->isLoggedIn()) {

            return true;

        }

        return false;

    }

    /**
     * Выход пользователя
     * @return void
     * @throws \Delight\Auth\AuthError
     */
    public function logout()
    {

        $this->auth->logOut();

        $this->flash->success('Вы не авторизованы');

        $this->redirect->redirectTo();

    }

    /**
     * Возвращает ошибки валидатора в виде строки
     * @param $arErrors
     * @return string
     */
    public function validatorErrorsPrerare($arErrors)
    {

        $arError = [];

        foreach ($arErrors as $arValue) {

            foreach ($arValue as $value) {

                $arError[] = $value;

            }

        }

        return implode(', ', $arError);

    }

    /**
     * Подключает шаблон для ошибки 404
     * @return void
     */
    public function error404()
    {

        $this->flash->error('404 Not Found');

        echo $this->engine->render('error404.view', []);

    }

}