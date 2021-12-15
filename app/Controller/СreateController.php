<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Delight\Auth\AuthError;
use Valitron\Validator;

class СreateController extends BaseController
{

    /**
     * Выводит форму добавления нового пользователя
     * @return void
     * @throws QueryBuilderException
     */
    public function create()
    {

        $this->checkAccess();

        //Получаем список доступных статусов
        $arStatus = $this->query->getAll('status');

        echo $this->engine->render('create.view', [
            'status' => $arStatus,
        ]);

    }

    /**
     * Обрабатывает запрос на добавление пользователя
     * @return void
     * @throws QueryBuilderException|AuthError
     */
    public function handlerCreate()
    {

        $this->checkAccess();

        $name = $this->request->getPost('name');
        $job = $this->request->getPost('job');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $vk = $this->request->getPost('vk');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $status = $this->request->getPost('status');
        $photo = $this->request->getFiles('photo');
        $instagram = $this->request->getPost('instagram');
        $telegram = $this->request->getPost('telegram');

        $arProfile = [
            'name' => $name,
            'job' => $job,
            'phone' => $phone,
            'address' => $address,
            'vk' => $vk,
            'status_id' => $status,
            'instagram' => $instagram,
            'telegram' => $telegram,
        ];

        //Получаем список доступных статусов
        $arStatus = $this->query->getAll('status');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['email', 'password']);
        $validator->rule('email', 'email');

        if (!$validator->validate()) {

            $this->flash->error('Введите E-mail и пароль');

        } else {

            $arProfile['photo'] = ($this->mediaValidator($photo)) ? $this->addPhoto($photo) : '';

            //Добавляем пользователя
            $arUser = $this->createUser($email, $password);

            if (!empty($arUser)) {

                //Обновляем профиль
                $this->query->update('profile', $arUser['profile'], $arProfile);

                $this->flash->success('Пользователь добавлен');

            }

        }

        echo $this->engine->render('create.view', [
            'profile' => $arProfile,
            'status' => $arStatus,
        ]);

    }

}