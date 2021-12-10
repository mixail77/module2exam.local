<?php

namespace App\Controller;

class MediaController extends BaseController
{

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

}