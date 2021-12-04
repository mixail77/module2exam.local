<?php

namespace App\Controller;

use App\Classes\Redirect;
use App\Classes\Request;
use Delight\Auth\Auth;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Tamtamchik\SimpleFlash\Flash;

class Controller
{

    public $auth;
    public $engine;
    public $flash;
    public $redirect;
    public $request;

    public function __construct(Auth $auth, Engine $engine, Asset $asset, Flash $flash, Redirect $redirect, Request $request)
    {

        $this->auth = $auth;
        $this->engine = $engine;
        $this->flash = $flash;
        $this->redirect = $redirect;
        $this->request = $request;

        $this->engine->loadExtension($asset);

    }

    public function isAuth()
    {

        if ($this->auth->isLoggedIn()) {

            return true;

        }

        return false;

    }

    public function error404()
    {

        $this->flash->error('404 Not Found');

        echo $this->engine->render('error404.view', []);

    }

}