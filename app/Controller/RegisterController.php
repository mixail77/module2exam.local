<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use RuntimeException;
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

    /**
     * Обрабатывает запрос на подтверждение Email адреса пользователя (по ссылке в письме)
     * @return void
     * @throws AuthError
     */
    public function confirmRegister()
    {

        $selector = $this->request->getQuery('selector');
        $token = $this->request->getQuery('token');

        $validator = new Validator($this->request->getAllQuery());
        $validator->rule('required', ['selector', 'token']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверная ссылка для подтверждения регистрации');

        } else if ($this->confirmEmail($selector, $token)) {

            $this->flash->success('Регистрация подтверждена');

        }

        echo $this->engine->render('register.view', []);

    }

    /**
     * Подтверждает Email адрес пользователя
     * @param $selector
     * @param $token
     * @return bool
     * @throws AuthError
     */
    public function confirmEmail($selector, $token)
    {

        try {

            $this->auth->confirmEmail($selector, $token);

            return true;

        } catch (InvalidSelectorTokenPairException $exception) {

            $this->flash->error('Ошибка. Неверный токен');

        } catch (TokenExpiredException $exception) {

            $this->flash->error('Ошибка. Срок действия токена истек');

        } catch (UserAlreadyExistsException $exception) {

            $this->flash->error('Ошибка. E-mail уже существует');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

}