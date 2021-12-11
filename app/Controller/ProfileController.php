<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class ProfileController extends BaseController
{

    /**
     * Выводит форму редактирования профиля пользователя
     * @return void
     * @throws QueryBuilderException
     */
    public function profile($vars)
    {

        $this->checkAccess();

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        //Получаем профиль пользователя по ID пользователя
        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('profile.view', [
            'user' => $arUser,
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

            //Получаем профиль пользователя по ID пользователя
            $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

    /**
     * Обрабатывает запрос на редактирование профиля
     * @return void
     */
    public function postProfileEdit($vars)
    {

        $this->checkAccess();

        $profileId = $this->request->getPost('profile_id');

        $arProfile = [
            'name' => $this->request->getPost('name'),
            'job' => $this->request->getPost('job'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else {

            try {

                $this->query->update('profile', $profileId, $arProfile);

                $this->flash->success('Данные сохранены');

            } catch (QueryBuilderException $exception) {

                $this->flash->error($exception->getMessage());

            }

        }

        $arProfile['id'] = $profileId;

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

}