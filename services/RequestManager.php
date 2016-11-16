<?php

class RequestManager
{
    protected $requestString;
    protected $controller;
    protected $action;
    protected $params;

    /**
     * RequestManager constructor.
     * @param $params
     */
    public function __construct()
    {
        $this->parseRequest();
        /*$this->params = [];*/
    }

    protected function parseRequest()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $res = explode("/", $this->requestString);
        var_dump($res);
    }


    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }



}