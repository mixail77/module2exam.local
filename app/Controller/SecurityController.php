<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\UserAlreadyExistsException;
use Valitron\Validator;

class SecurityController extends BaseController
{

    /**
     * Выводит форму редактирования пароля
     * @return void
     * @throws \App\Exception\QueryBuilderException
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
     * @throws QueryBuilderException
     */
    public function postProfileSecurityEdit($vars)
    {

        $this->checkAccess();

        $email = $this->request->getPost('email');
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email']);
        $validator->rule('email', 'email');

        if (!empty($newPassword)) {

            $validator->rule('required', ['old_password', 'new_password']);

        }

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else if ($this->changeEmail($oldPassword, $email) && $this->changePassword($vars['id'], $newPassword)) {

            $this->flash->success('Данные сохранены');

        }

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        echo $this->engine->render('security.view', [
            'user' => $arUser,
        ]);

    }

    /**
     * Меняет E-mail пользователя
     * @param $password
     * @param $email
     * @return false
     * @throws AuthError
     */
    public function changeEmail($password, $email)
    {

        try {

            if ($this->auth->reconfirmPassword($password)) {

                $this->auth->changeEmail($email, function ($selector, $token) {

                    $this->auth->confirmEmail($selector, $token);

                    return true;

                });
            }

            $this->flash->error('Ошибка. Введите текущий пароль');

        } catch (InvalidEmailException $exception) {

            $this->flash->error('Ошибка. Неверный E-mail');

        } catch (UserAlreadyExistsException $exception) {

            $this->flash->error('Ошибка. E-mail уже существует');

        } catch (EmailNotVerifiedException $exception) {

            $this->flash->error('Ошибка. Аккаунт не подтвержден');

        } catch (NotLoggedInException $exception) {

            $this->flash->error('Ошибка. Пользователь не авторизован');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

    /**
     * Меняет пароль пользователя
     * @param $userId
     * @param $password
     * @return bool
     * @throws AuthError
     */
    public function changePassword($userId, $password)
    {

        if (empty($password)) {

            return true;

        }

        try {

            $this->auth->admin()->changePasswordForUserById($userId, $password);

            return true;

        } catch (UnknownIdException $exception) {

            $this->flash->error('Ошибка. Пользователь не найден');

        } catch (InvalidPasswordException $exception) {

            $this->flash->error('Ошибка. Неверный пароль');

        }

        return false;

    }

}