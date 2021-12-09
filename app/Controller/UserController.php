<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;

class UserController extends Controller
{

    /**
     * Возвращает список пользователей
     * @return void
     */
    public function users()
    {

        try {

            $users = $this->query->getAll('users');

        } catch (QueryBuilderException $exception) {

            $this->flash->error('Ошибка. Список пользователей');

        }

        echo $this->engine->render('users.view', [
            'users' => $users,
            'profile' => $profile,
        ]);

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

    public function profileEdit($vars)
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