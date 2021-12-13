<?php

namespace App\Controller;

use Delight\Auth\AuthError;
use Delight\Auth\UnknownIdException;

class DeleteController extends BaseController
{

    /**
     * Обрабатывает запрос на удаление пользователя
     * @return void
     * @throws AuthError
     */
    public function profileDelete($vars)
    {

        $this->checkAccess();

        if ($this->deleteUser($vars['id'])) {

            $this->redirect->redirectTo();

        }

        $this->redirect->redirectTo();

        echo $this->engine->render('delete.view', []);

    }

    /**
     * Удаляет пользователя по ID
     * @param $userId
     * @return bool
     * @throws AuthError
     */
    public function deleteUser($userId)
    {

        if (!$this->isMyProfile($userId)) {

            try {

                $this->auth->admin()->deleteUserById($userId);
                $this->auth->logOut();

                return true;

            } catch (UnknownIdException $exception) {

                $this->flash->error('Ошибка. Пользователь не найден');

            }

        } else {

            $this->flash->error('Ошибка. Нельзя удалить самого себя');

        }

        return false;

    }

}