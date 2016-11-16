<?php

class FrontController extends Controller
{
    protected $defaultController = 'Product';
    protected $defaultRunAction = 'index';

    /**
     * Действие, выполняемое по умолчанию
     * @return mixed
     */
    public function actionIndex()
    {
        $this->registerAutoloads();

        $rm = new RequestManager;
        $controllerName = $rm->getController();
        $action = $rm->getAction();

        if(empty($controllerName)){
            $controllerName = $this->defaultController;
            $action = $this->defaultAction;
        }

        /** @var Controller $controller */
        $controller = new $controllerName;
        $controller->run($action);
    }

    protected function registerAutoloads()
    {
        require_once 'services/Autoloader.php';
        spl_autoload_register([new Autoloader(), 'getClass']);
        require_once 'vendor/autoload.php';
    }


}