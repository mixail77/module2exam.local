<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;

class UsersController extends BaseController
{

    /**
     * Возвращает список пользователей
     * @return void
     * @throws QueryBuilderException
     */
    public function users()
    {

        $this->checkAccess();

        $users = $this->query->getAll('users');
        $profile = $this->query->getAll('profile');

        echo $this->engine->render('users.view', [
            'users' => $users,
            'profile' => $profile,
        ]);

    }

}