<?php

namespace App\Controller;

class DeleteController extends BaseController
{

    /**
     * Обрабатывает запрос на удаление пользователя
     * @return void
     */
    public function profileDelete()
    {

        echo $this->engine->render('delete.view', []);

    }

}