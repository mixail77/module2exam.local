<?php

namespace App\Controller;

use Delight\Auth\AttemptCancelledException;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;
use Valitron\Validator;

class AuthController extends BaseController
{

    private $duration;

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
    public function postAuth()
    {

        $this->checkAccess('guest');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email', 'password']);
        $validator->rule('email', 'email');

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверный E-mail или пароль');

        } else if ($this->authUser()) {

            $this->flash->success('Вы авторизованы');

            //Редирект на список пользователей
            $this->redirect->redirectTo('/users/');

        }

        echo $this->engine->render('authorize.view', [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'remember' => $this->request->getPost('remember'),
        ]);

    }

    /**
     * Авторизует и запоминает пользователя
     * @return bool
     * @throws AttemptCancelledException
     * @throws AuthError
     */
    private function authUser()
    {

        try {

            if ($this->request->getPost('remember') === 'Y') {

                $this->duration = (int)(60 * 60 * 24 * 365.25);

            }

            $this->auth->login($this->request->getPost('email'), $this->request->getPost('password'), $this->duration);

            return true;

        } catch (InvalidEmailException $exception) {

            $this->flash->error('Ошибка. Неверный E-mail');

        } catch (InvalidPasswordException $exception) {

            $this->flash->error('Ошибка. Неверный пароль');

        } catch (EmailNotVerifiedException $exception) {

            $this->flash->error('Ошибка. E-mail не подтвержден');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

}