<?php

namespace App\Controller;

class СreateController extends BaseController
{

    /**
     * Выводит форму добавления нового пользователя
     * @return void
     */
    public function create()
    {

        $this->checkAccess();

        echo $this->engine->render('create.view', []);

    }

    /**
     * Обрабатывает запрос на добавление пользователя
     * @return void
     */
    public function postCreate()
    {

        $this->checkAccess();

        echo $this->engine->render('create.view', []);

    }

}