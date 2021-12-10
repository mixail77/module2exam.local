<?php

namespace App\Controller;

class ErrorController extends BaseController
{

    /**
     * Подключает шаблон для страницы с ошибкой
     * @return void
     */
    public function pageNotFound()
    {

        $this->flash->error('Ошибка 404. Нет такой страницы');

        echo $this->engine->render('error404.view', []);

    }

}