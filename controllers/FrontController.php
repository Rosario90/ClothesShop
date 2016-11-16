<?php

class FrontController extends Controller
{
    protected $defaultController = 'product';
    protected $defaultRunAction = 'index';

    /**
     * Действие, выполняемое по умолчанию
     * @return mixed
     */
    public function actionIndex()
    {
        /*$this->registerAutoloads();*/


        $rm = new RequestManager;
        $controllerName = $rm->getController();
        $action = $rm->getAction();

        if(empty($controllerName)){
            $controllerName = $this->defaultController;
            $action = $this->defaultAction;
        }

        $controllerName = ucfirst($controllerName) . 'Controller';
        /** @var Controller $controller */
        $controller = new $controllerName;
        $controller->run($action);
    }

    /*protected function registerAutoloads()
    {

    }*/


}