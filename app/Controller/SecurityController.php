<?php

namespace App\Controller;

class SecurityController extends BaseController
{

    /**
     * Выводит форму редактирования пароля
     * @return void
     */
    public function profileSecurity()
    {

        echo $this->engine->render('security.view', []);

    }

    /**
     * Обрабатывает запрос на редактирование пароля
     * @return void
     */
    public function postProfileSecurityEdit()
    {



    }

}