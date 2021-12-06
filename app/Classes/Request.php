<?php

namespace App\Classes;

class Request
{

    private $arPost;
    private $arQuery;
    private $arServer;
    private $postValue;
    private $queryValue;
    private $serverValue;

    public function __construct()
    {

        $this->arPost = $_POST;
        $this->arQuery = $_GET;
        $this->arServer = $_SERVER;

    }

    /**
     * Возвращает массив $_POST
     * @return array
     */
    public function getAllPost()
    {

        return $this->arPost;

    }

    /**
     * Возвращает безопасное значение из $_POST массива по ключу
     * @param $key
     * @return string
     */
    public function getPost($key)
    {

        $this->postValue = trim(strip_tags($this->arPost[$key]));

        return $this->postValue;

    }

    /**
     * Возвращает массив $_GET
     * @return array
     */
    public function getAllQuery()
    {

        return $this->arQuery;

    }

    /**
     * Возвращает безопасное значение из $_GET массива по ключу
     * @param $key
     * @return string
     */
    public function getQuery($key)
    {

        $this->queryValue = trim(strip_tags($this->arQuery[$key]));

        return $this->queryValue;

    }

    /**
     * Возвращает массив $_SERVER
     * @return array
     */
    public function getAllServer()
    {

        return $this->arServer;

    }

    /**
     * Возвращает значение из $_SERVER массива по ключу
     * @param $key
     * @return string
     */
    public function getServer($key)
    {

        $this->serverValue = $this->arServer[$key];

        return $this->serverValue;

    }

}
