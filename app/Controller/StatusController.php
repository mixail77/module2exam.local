<?php

namespace App\Controller;

class StatusController extends BaseController
{

    /**
     * Выводит форму редактирования статуса
     * @return void
     */
    public function profileStatus()
    {

        $this->checkAccess();

        echo $this->engine->render('status.view', []);

    }

    /**
     * Обрабатывает запрос на редактирование статуса
     * @return void
     */
    public function postProfileStatusEdit()
    {

        $this->checkAccess();



    }

}