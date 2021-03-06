<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class ProfileController extends BaseController
{

    /**
     * Выводит профиль пользователя
     * @return void
     * @throws QueryBuilderException
     */
    public function profile($vars)
    {

        $this->checkAccess();

        //Пользователь
        $arUser = $this->query->getById('users', $vars['id']);

        //Профиль пользователя
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
     * @throws QueryBuilderException
     */
    public function profileEdit($vars)
    {

        $this->checkAccess();

        //Профиль пользователя
        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

    /**
     * Обрабатывает запрос на редактирование профиля
     * @return void
     * @throws QueryBuilderException
     */
    public function handlerProfile($vars)
    {

        $this->checkAccess();

        $name = $this->request->getPost('name');
        $job = $this->request->getPost('job');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $vk = $this->request->getPost('vk');
        $instagram = $this->request->getPost('instagram');
        $telegram = $this->request->getPost('telegram');
        $profileId = $this->request->getPost('profile_id');

        $arProfile = [
            'name' => $name,
            'job' => $job,
            'phone' => $phone,
            'address' => $address,
            'vk' => $vk,
            'instagram' => $instagram,
            'telegram' => $telegram,
        ];

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else {

            $this->query->update('profile', $profileId, $arProfile);

            $this->flash->success('Данные сохранены');

        }

        $arProfile['id'] = $profileId;

        echo $this->engine->render('edit.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

}