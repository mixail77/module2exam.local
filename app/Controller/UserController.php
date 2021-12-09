<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class UserController extends Controller
{

    /**
     * Возвращает список пользователей
     * @return void
     */
    public function users()
    {

        if (!$this->isAuth()) {

            $this->redirect->redirectTo();

        }

        try {

            $users = $this->query->getAll('users');
            $profile = $this->query->getAll('users');

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

        echo $this->engine->render('users.view', [
            'users' => $users,
            'profile' => $profile,
        ]);

    }

    /**
     * Выводит форму добавления нового пользователя
     * @return void
     */
    public function create()
    {

        echo $this->engine->render('create.view', []);

    }

    /**
     * Обрабатывает запрос на добавление пользователя
     * @return void
     */
    public function postCreate()
    {



    }

    /**
     * Выводит форму редактирования профиля пользователя
     * @return void
     */
    public function profile($vars)
    {

        try {

            $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

        echo $this->engine->render('profile.view', [
            'profile' => $arProfile,
        ]);

    }

    /**
     * Выводит форму редактирования профиля пользователя
     * @param $vars
     * @return void
     */
    public function profileEdit($vars)
    {

        try {

            $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
        ]);

    }

    /**
     * Обрабатывает запрос на редактирование профиля
     * @return void
     */
    public function postProfileEdit($vars)
    {

        $arProfile = [
            'name' => $this->request->getPost('name'),
            'job' => $this->request->getPost('job'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Редактировать пользователя');

        } else {

            try {

                $this->query->update('profile', $this->request->getPost('profile_id'), $arProfile);

                $this->flash->success('Данные сохранены');

                //Редирект на страницу редактирования профиля
                $this->redirect->redirectTo('/profile/' . $vars['id'] . '/edit/');

            } catch (QueryBuilderException $exception) {

                $this->flash->error($exception->getMessage());

            }

        }

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
        ]);

    }

    /**
     * Выводит форму добавления фотографии
     * @return void
     */
    public function profileMedia()
    {

        echo $this->engine->render('media.view', []);

    }

    /**
     * Обрабатывает запрос на добавление фотографии
     * @return void
     */
    public function postProfileMediaEdit()
    {



    }

    /**
     * Выводит форму редактирования статуса
     * @return void
     */
    public function profileStatus()
    {

        echo $this->engine->render('status.view', []);

    }

    /**
     * Обрабатывает запрос на редактирование статуса
     * @return void
     */
    public function postProfileStatusEdit()
    {



    }

    /**
     * Выводит форму редактирования пароля
     * @return void
     */
    public function profileSecurity()
    {

        echo $this->engine->render('security.view', []);

    }

    /**
     * Обрабатывает запрос на редактирование пароля
     * @return void
     */
    public function postProfileSecurityEdit()
    {



    }

    /**
     * Обрабатывает запрос на удаление пользователя
     * @return void
     */
    public function profileDelete()
    {

        echo $this->engine->render('delete.view', []);

    }

}