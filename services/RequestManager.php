<?php

class RequestManager
{
    protected $requestString;
    protected $controller;
    protected $action;
    protected $params;
    protected $rules;

    /**
     * RequestManager constructor.
     * @param $params
     */
    public function __construct()
    {
        $this->rules = [
            '#(?P<controller>\w+)/(?P<action>\w+)[/]?(?P<params>.*)#u'
        ];
        $this->parseRequest();
    }

    protected function parseRequest()
    {
        $this->requestString = preg_replace(['#^\/#u','#\/$#u'], '', substr($_SERVER['REQUEST_URI'], 12));
        foreach ($this->rules as $rule){
            if(preg_match_all($rule, $this->requestString, $matches)){
                $this->controller = $matches['controller'][0];
                $this->action = $matches['action'][0];
                $this->params = explode("/", $matches['params'][0]);
                break;
            }
        }
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