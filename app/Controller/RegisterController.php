<?php

namespace App\Controller;

class RegisterController extends Controller
{

    public function register()
    {

        echo $this->engine->render('register.view', []);

    }

    public function postRegister()
    {

        echo $this->engine->render('register.view', []);

    }

}