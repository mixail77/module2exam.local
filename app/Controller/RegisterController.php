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

    const STATUS_DEFAULT = 4;

    private $userId;
    private $email;
    private $selector;
    private $token;

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
    public function postRegister()
    {

        $this->checkAccess('guest');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email', 'password']);
        $validator->rule('email', 'email');

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверный E-mail или пароль');

        } else if ($this->createUser() && $this->createProfile() && $this->sendConfirm()) {

            $this->flash->success('Вы зарегистрированы. На указанный E-mail отправлено письмо для активации учетной записи');

            //Редирект на главную
            $this->redirect->redirectTo();

        }

        echo $this->engine->render('register.view', [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

    }

    /**
     * Регистрирует нового пользователя
     * @return bool
     * @throws AuthError
     */
    private function createUser()
    {

        try {

            $userId = $this->auth->register($this->request->getPost('email'), $this->request->getPost('password'), '', function ($selector, $token) {
                $this->selector = $selector;
                $this->token = $token;
            });

            //ID пользователя
            $this->userId = $userId;

            //Email пользователя
            $this->email = $this->request->getPost('email');

            return true;

        } catch (InvalidEmailException $exception) {

            $this->flash->error('Ошибка. Неверный E-mail');

        } catch (InvalidPasswordException $exception) {

            $this->flash->error('Ошибка. Неверный пароль');

        } catch (UserAlreadyExistsException $exception) {

            $this->flash->error('Ошибка. Пользователь уже существует');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

    /**
     * Создает профиль пользователя
     * @return bool
     */
    private function createProfile()
    {

        try {

            $this->query->create('profile', [
                'user_id' => $this->userId,
                'status_id' => self::STATUS_DEFAULT,

            ]);

            return true;

        } catch (QueryBuilderException $exception) {

            $this->flash->error('Ошибка. Не создан профиль пользователя');

        }

        return false;

    }

    /**
     * Отправляет ссылку для подтверждения регистрации пользователя
     * @return bool
     */
    private function sendConfirm()
    {

        try {

            $confirmUrl = 'http://' . $this->request->getServer('SERVER_NAME') . '/confirm/?selector=' . $this->selector . '&token=' . $this->token;
            $message = 'Подтверждение регистрации: ' . $confirmUrl;

            $this->mail->setTo($this->email, $this->email);
            $this->mail->setFrom('confirm@yandex.ru', 'confirm@yandex.ru');
            $this->mail->setSubject('Подтверждение регистрации');
            $this->mail->setMessage($message);
            $this->mail->send();

            return true;

        } catch (RuntimeException $exception) {

            $this->flash->error('Ошибка. Не отправлено письмо для активации учетной записи');

        }

        return false;

    }

    /**
     * Подтверждает регистрацию пользователя по ссылке
     * @return void
     * @throws AuthError
     */
    public function confirmRegister()
    {

        $validator = new Validator($this->request->getAllQuery());
        $validator->rule('required', ['selector', 'token']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверная ссылка для подтверждения регистрации');

        } else {

            try {

                $this->auth->confirmEmail($this->request->getQuery('selector'), $this->request->getQuery('token'));

                $this->flash->success('Регистрация подтверждена');

            } catch (InvalidSelectorTokenPairException $exception) {

                $this->flash->error('Ошибка. Неверный токен');

            } catch (TokenExpiredException $exception) {

                $this->flash->error('Ошибка. Срок действия токена истек');

            } catch (UserAlreadyExistsException $exception) {

                $this->flash->error('Ошибка. E-mail уже существует');

            } catch (TooManyRequestsException $exception) {

                $this->flash->error('Ошибка. Слишком много запросов');

            }

        }

        echo $this->engine->render('register.view', []);

    }

}