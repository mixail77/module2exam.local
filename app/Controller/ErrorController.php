<?php

namespace App\Controller;

class ErrorController extends BaseController
{

    /**
     * Подключает шаблон для страницы с ошибкой
     * @return void
     */
    public function error404()
    {

        $this->flash->error('404 Not Found');

        echo $this->engine->render('error404.view', []);

    }

}