<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;

class DeleteController extends BaseController
{

    /**
     * Обрабатывает запрос на удаление пользователя
     * @return void
     * @throws AuthError|QueryBuilderException
     */
    public function profileDelete($vars)
    {

        $this->checkAccess();

        if ($this->deleteUser($vars['id'])) {

            $this->flash->success('Пользователь удален');

        }

        $this->redirect->redirectTo();

    }

}