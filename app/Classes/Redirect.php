<?php

namespace App\Classes;

class Redirect
{

    /**
     * Выполняет редирект на страницу
     * @param $url
     * @return void
     */
    public function redirectTo($url = '/')
    {

        header('Location: ' . $url);
        exit();

    }

}