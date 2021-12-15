<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Valitron\Validator;

class SecurityController extends BaseController
{

    /**
     * Выводит форму редактирования пароля
     * @return void
     * @throws QueryBuilderException
     */
    public function profileSecurity($vars)
    {

        $this->checkAccess();

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        echo $this->engine->render('security.view', [
            'user' => $arUser,
        ]);

    }

    /**
     * Обрабатывает запрос на редактирование пароля
     * @return void
     * @throws QueryBuilderException|AuthError
     */
    public function handlerProfileSecurity($vars)
    {

        $this->checkAccess();

        $email = $this->request->getPost('email');
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email']);
        $validator->rule('email', 'email');

        //Если передан новый пароль
        if (!empty($newPassword)) {

            $validator->rule('required', ['old_password', 'new_password']);

        }

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else if ($this->changeEmail($oldPassword, $email, $arUser['email']) && $this->changePassword($oldPassword, $newPassword)) {

            $this->flash->success('Данные сохранены');

        }

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        echo $this->engine->render('security.view', [
            'user' => $arUser,
        ]);

    }

}