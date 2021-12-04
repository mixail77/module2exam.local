<?php

namespace App\Classes;

class Redirect
{

    public function redirectTo($url)
    {

        header('Location: ' . $url);
        exit();

    }

}