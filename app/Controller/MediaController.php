<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Valitron\Validator;

class MediaController extends BaseController
{

    /**
     * Выводит форму добавления фотографии
     * @return void
     * @throws QueryBuilderException
     */
    public function profileMedia($vars)
    {

        $this->checkAccess();

        //Получаем профиль пользователя по ID пользователя
        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('media.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

    /**
     * Обрабатывает запрос на добавление фотографии
     * @return void
     * @throws QueryBuilderException
     */
    public function handlerProfileMedia($vars)
    {

        $this->checkAccess();

        $profileId = $this->request->getPost('profile_id');
        $arPhoto = $this->request->getFiles('photo');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate() || !$this->mediaValidator($arPhoto)) {

            $this->flash->error('Выберите фотографию');

        } else {

            $this->query->update('profile', $profileId, ['photo' => $this->addPhoto($arPhoto)]);

            $this->flash->success('Данные сохранены');
        }

        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('media.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

}