<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Delight\Auth\UnknownIdException;

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

        echo $this->engine->render('delete.view', []);

    }

    /**
     * Удаляет пользователя по ID
     * @param $userId
     * @return bool
     * @throws AuthError|QueryBuilderException
     */
    public function deleteUser($userId)
    {

        if (!$this->isMyProfile($userId)) {

            try {

                //Профиль пользователя
                $arProfile = $this->query->getProfileByUserId('profile', $userId);

                //Удаляем фотографию
                unlink($_SERVER['DOCUMENT_ROOT'] . '/public/' . $arProfile['photo']);

                //Удаляем профиль
                $this->query->delete('profile', $arProfile['id']);

                //Удаляем пользователя
                $this->auth->admin()->deleteUserById($userId);

                //Завершаем сессию пользователя
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