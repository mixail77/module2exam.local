<?php

namespace App\Controller;

class UsersController extends BaseController
{

    /**
     * Возвращает список пользователей
     * @return void
     */
    public function users()
    {

        $this->checkAccess();

        $users = $this->query->getAllUser();

        echo $this->engine->render('users.view', [
            'users' => $users
        ]);

    }

}