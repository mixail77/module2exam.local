<?php

namespace App\Controller;

class UserController extends Controller
{

    public function users()
    {

        echo $this->engine->render('users.view', []);

    }

    public function create()
    {

        echo $this->engine->render('create.view', []);

    }

    public function postCreate()
    {


    }

    public function profile()
    {

        echo $this->engine->render('profile.view', []);

    }

    public function profileEdit()
    {

        echo $this->engine->render('edit.view', []);

    }

    public function postProfileEdit()
    {


    }

    public function profileMedia()
    {

        echo $this->engine->render('media.view', []);

    }

    public function postProfileMediaEdit()
    {


    }

    public function profileStatus()
    {

        echo $this->engine->render('status.view', []);

    }

    public function postProfileStatusEdit()
    {


    }

    public function profileSecurity()
    {

        echo $this->engine->render('security.view', []);

    }

    public function postProfileSecurityEdit()
    {


    }

    public function profileDelete()
    {

        echo $this->engine->render('delete.view', []);

    }

}