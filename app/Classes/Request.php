<?php

namespace App\Classes;

class Request
{

    private $arPost;
    private $arQuery;
    private $arServer;
    private $arSession;
    private $arFiles;

    private $postValue;
    private $queryValue;
    private $serverValue;
    private $sessionValue;
    private $filesValue;

    public function __construct()
    {

        $this->arPost = $_POST;
        $this->arQuery = $_GET;
        $this->arServer = $_SERVER;
        $this->arFiles = $_FILES;
        $this->arSession = $_SESSION;

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

    /**
     * Возвращает массив $_SESSION
     * @return array
     */
    public function getAllSession()
    {

        return $this->arSession;

    }

    /**
     * Возвращает значение из $_SESSION массива по ключу
     * @param $key
     * @return mixed
     */
    public function getSession($key)
    {

        $this->sessionValue = $this->arSession[$key];

        return $this->sessionValue;

    }

    /**
     * Возвращает массив $_FILES
     * @return array
     */
    public function getAllFiles()
    {

        return $this->arFiles;

    }

    /**
     * Возвращает значение из $_FILES массива по ключу
     * @return array
     */
    public function getFiles($key)
    {

        $this->filesValue = $this->arFiles[$key];

        return $this->filesValue;

    }

}
