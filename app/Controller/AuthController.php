<?php

namespace App\Controller;

class AuthController extends Controller
{

    public function auth()
    {

        echo $this->engine->render('authorize.view', []);

    }

    public function postAuth()
    {

        echo $this->engine->render('authorize.view', []);

    }


}