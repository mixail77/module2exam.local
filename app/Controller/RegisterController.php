<?php

namespace App\Controller;

use Delight\Auth\AuthError;
use Valitron\Validator;

class RegisterController extends BaseController
{

    /**
     * Выводит форму регистрации
     * @return void
     */
    public function register()
    {

        $this->checkAccess('guest');

        echo $this->engine->render('register.view', []);

    }

    /**
     * Обрабатывает запрос на регистрацию
     * @return void
     * @throws AuthError
     */
    public function handlerRegister()
    {

        $this->checkAccess('guest');

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email', 'password']);
        $validator->rule('email', 'email');

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверный E-mail или пароль');

        } else if ($this->createUser($email, $password)) {

            $this->flash->success('Вы зарегистрированы. На указанный E-mail отправлено письмо для активации учетной записи');

            //Редирект на главную
            $this->redirect->redirectTo();

        }

        echo $this->engine->render('register.view', [
            'email' => $email,
            'password' => $password,
        ]);

    }

}