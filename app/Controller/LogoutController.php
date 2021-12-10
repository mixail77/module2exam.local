<?php

namespace App\Controller;

use Delight\Auth\AuthError;

class LogoutController extends BaseController
{

    /**
     * Завершение сеанса пользователя
     * @return void
     * @throws AuthError
     */
    public function logout()
    {

        $this->checkAccess();

        $this->auth->logOut();

        $this->flash->error('Сеанс пользователя завершен');

        $this->redirect->redirectTo();

    }

}