<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
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

    /**
     * Меняет E-mail пользователя
     * @param $oldPassword
     * @param $newEmail
     * @param $oldEmail
     * @return false
     * @throws AuthError
     */
    public function changeEmail($oldPassword, $newEmail, $oldEmail)
    {

        try {

            if ($this->auth->reconfirmPassword($oldPassword)) {

                //Если старый и новый Email не совпадают
                if ($newEmail != $oldEmail) {

                    $this->auth->changeEmail($newEmail, function ($selector, $token) {

                        //Подтверждаем адрес
                        $this->auth->confirmEmail($selector, $token);

                    });

                }

                return true;

            } else {

                $this->flash->error('Ошибка. Введите текущий пароль');

            }

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
     * @param $oldPassword
     * @param $newPassword
     * @return bool
     * @throws AuthError
     */
    public function changePassword($oldPassword, $newPassword)
    {

        try {

            //Если передан новый пароль
            if (!empty($newPassword)) {

                $this->auth->changePassword($oldPassword, $newPassword);

            }

            return true;

        } catch (NotLoggedInException $exception) {

            $this->flash->error('Ошибка. Пользователь не авторизован');

        } catch (InvalidPasswordException $exception) {

            $this->flash->error('Ошибка. Неверный пароль');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

}