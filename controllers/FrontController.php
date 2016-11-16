<?php

class FrontController extends Controller
{
    /**
     * Действие, выполняемое по умолчанию
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var Controller $controller */
        $controller = new ControllerName;
        $controller->run($action);
    }


}