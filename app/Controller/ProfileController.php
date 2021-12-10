<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class ProfileController extends BaseController
{

    /**
     * Выводит форму редактирования профиля пользователя
     * @return void
     */
    public function profile($vars)
    {

        $this->checkAccess();

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

        $this->checkAccess();

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

        $this->checkAccess();

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

}