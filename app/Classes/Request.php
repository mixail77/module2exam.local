<?php

namespace App\Classes;

class Request
{

    private $arPost;
    private $arQuery;
    private $postValue;
    private $queryValue;

    public function __construct()
    {

        $this->arPost = $_POST;
        $this->arQuery = $_GET;

    }

    public function getPost($key)
    {

        $this->postValue = trim(strip_tags($this->arPost[$key]));

        return $this->postValue;

    }

    public function getQuery($key)
    {

        $this->queryValue = trim(strip_tags($this->arQuery[$key]));

        return $this->queryValue;

    }

}
