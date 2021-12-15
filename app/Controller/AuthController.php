<?php

namespace App\Controller;

use Delight\Auth\AttemptCancelledException;
use Delight\Auth\AuthError;
use Valitron\Validator;

class AuthController extends BaseController
{

    /**
     * Выводит форму авторизации
     * @return void
     */
    public function auth()
    {

        $this->checkAccess('guest');

        echo $this->engine->render('authorize.view', []);

    }

    /**
     * Обрабатывает запрос на авторизацию
     * @return void
     * @throws AttemptCancelledException
     * @throws AuthError
     */
    public function handlerAuth()
    {

        $this->checkAccess('guest');

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email', 'password']);
        $validator->rule('email', 'email');

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверный E-mail или пароль');

        } else if ($this->authUser($email, $password, $remember)) {

            $this->flash->success('Вы авторизованы');

            //Редирект на список пользователей
            $this->redirect->redirectTo('/users/');

        }

        echo $this->engine->render('authorize.view', [
            'email' => $email,
            'password' => $password,
            'remember' => $remember,
        ]);

    }

}