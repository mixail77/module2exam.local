<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class StatusController extends BaseController
{

    /**
     * Выводит форму редактирования статуса
     * @return void
     * @throws QueryBuilderException
     */
    public function profileStatus($vars)
    {

        $this->checkAccess();

        //Список статусов
        $arStatus = $this->query->getAll('status');

        //Профиль пользователя
        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('status.view', [
            'profile' => $arProfile,
            'status' => $arStatus,
            'user_id' => $vars['id'],
        ]);

    }

    /**
     * Обрабатывает запрос на редактирование статуса
     * @return void
     * @throws QueryBuilderException
     */
    public function handlerProfileStatus($vars)
    {

        $this->checkAccess();

        $profileId = $this->request->getPost('profile_id');
        $statusId = $this->request->getPost('status_id');

        $arProfile = [
            'status_id' => $statusId,
        ];

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else {

            //Обновляем профиль пользователя
            $this->query->update('profile', $profileId, $arProfile);

            $this->flash->success('Данные сохранены');

        }

        //Список статусов
        $arStatus = $this->query->getAll('status');

        $arProfile['id'] = $profileId;

        echo $this->engine->render('status.view', [
            'profile' => $arProfile,
            'status' => $arStatus,
            'user_id' => $vars['id'],
        ]);

    }

}