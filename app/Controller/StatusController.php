<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class StatusController extends BaseController
{

    /**
     * Выводит форму редактирования статуса
     * @return void
     */
    public function profileStatus($vars)
    {

        $this->checkAccess();

        try {

            //Получаем список доступных статусов
            $arStatus = $this->query->getAll('status');

            //Получаем профиль пользователя по ID пользователя
            $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        } catch (QueryBuilderException $exception) {

            $this->flash->error($exception->getMessage());

        }

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

        $arProfile = [
            'status_id' => $this->request->getPost('status_id'),
        ];

        $arStatus = $this->query->getAll('status');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка валидации');

        } else {

            //Обновляем профиль пользователя
            $this->query->update('profile', $profileId, $arProfile);

            $this->flash->success('Данные сохранены');

        }

        $arProfile['id'] = $profileId;

        echo $this->engine->render('status.view', [
            'profile' => $arProfile,
            'status' => $arStatus,
            'user_id' => $vars['id'],
        ]);

    }

}