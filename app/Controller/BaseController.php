<?php

namespace App\Controller;

use App\Classes\QueryBuilder;
use App\Classes\Redirect;
use App\Classes\Request;
use Delight\Auth\Auth;
use Delight\Auth\Role;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use SimpleMail;
use Tamtamchik\SimpleFlash\Flash;

class BaseController
{

    public QueryBuilder $query;
    public Auth $auth;
    public Engine $engine;
    public Flash $flash;
    public SimpleMail $mail;
    public Redirect $redirect;
    public Request $request;

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
     * Проверяет роль пользователя (администратор)
     * @return bool
     */
    public function isAdmin()
    {

        if ($this->auth->hasRole(Role::ADMIN)) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет доступ к профилю пользователя
     * @param $id
     * @return bool
     */
    public function isMyProfile($id)
    {

        if ($this->auth->getUserId() == $id) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет доступ для гостей и участников системы
     * @param $type
     * @return void
     */
    public function checkAccess($type = 'member')
    {

        //Если тип пользователя гость и авторизован
        if ($type == 'guest' && $this->isAuth()) {

            $this->redirect->redirectTo('/users/');

        }

        //Если тип пользователя участник и не авторизован
        if ($type == 'member' && !$this->isAuth()) {

            $this->redirect->redirectTo();

        }
        
    }

}