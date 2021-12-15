<?php

namespace App\Controller;

use Delight\Auth\AuthError;
use Valitron\Validator;

class ConfirmController extends BaseController
{

    /**
     * Обрабатывает запрос на подтверждение Email адреса пользователя (по ссылке в письме)
     * @return void
     * @throws AuthError
     */
    public function confirm()
    {

        $selector = $this->request->getQuery('selector');
        $token = $this->request->getQuery('token');

        $validator = new Validator($this->request->getAllQuery());
        $validator->rule('required', ['selector', 'token']);

        if (!$validator->validate()) {

            $this->flash->error('Ошибка. Неверная ссылка для подтверждения регистрации');

        } else if ($this->confirmEmail($selector, $token)) {

            $this->flash->success('Регистрация подтверждена');

        }

        echo $this->engine->render('register.view', []);

    }

}