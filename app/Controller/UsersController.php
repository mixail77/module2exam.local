<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;

class UsersController extends BaseController
{

    /**
     * Возвращает список пользователей
     * @return void
     */
    public function users()
    {

        if (!$this->isAuth()) {

            $this->redirect->redirectTo();

        }

        try {

            $users = $this->query->getAll('users');
            $profile = $this->query->getAll('profile');

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

        echo $this->engine->render('users.view', [
            'users' => $users,
            'profile' => $profile,
        ]);

    }

}