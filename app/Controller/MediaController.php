<?php

namespace App\Controller;

use App\Exception\QueryBuilderException;
use Intervention\Image\ImageManager;
use Valitron\Validator;

class MediaController extends BaseController
{

    const PHOTO_TYPE = ['jpg', 'jpeg', 'png', 'gif'];

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
     */
    public function postProfileMediaEdit($vars)
    {

        $this->checkAccess();

        $profileId = $this->request->getPost('profile_id');
        $arPhoto = $this->request->getFiles('photo');

        $validator = new Validator($this->request->getAllPost());
        $validator->rule('required', ['profile_id']);

        if (!$validator->validate() || !$this->mediaValidator($arPhoto)) {

            $this->flash->error('Ошибка валидации');

        } else {

            try {

                $this->query->update('profile', $profileId, ['photo' => $this->addPhoto($arPhoto)]);

                $this->flash->success('Данные сохранены');

            } catch (QueryBuilderException $exception) {

                $this->flash->error($exception->getMessage());

            }

        }

        $arProfile = $this->query->getProfileByUserId('profile', $vars['id']);

        echo $this->engine->render('media.view', [
            'profile' => $arProfile,
            'user_id' => $vars['id'],
        ]);

    }

    /**
     * Проверяет загружаемую фотографию
     * @param $arPhoto
     * @return bool
     */
    public function mediaValidator($arPhoto)
    {

        if (empty($arPhoto) || $arPhoto['error'] !== 0) {

            return false;

        } else {

            //Тип файла
            $arExtension = pathinfo($arPhoto['name'], PATHINFO_EXTENSION);

            if (!in_array($arExtension, self::PHOTO_TYPE)) {

                return false;

            }

        }

        return true;

    }

    /**
     * Загружает и сохраняет новую фотографию
     * @param $arPhoto
     * @return string
     */
    public function addPhoto($arPhoto)
    {

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($arPhoto['tmp_name']);

        $photoPath = '/upload/photo/' . mb_strtolower(mt_rand(0, 10000) . $arPhoto['name']);

        $image->save($_SERVER['DOCUMENT_ROOT'] . '/public/' . $photoPath);

        return $photoPath;

    }

}