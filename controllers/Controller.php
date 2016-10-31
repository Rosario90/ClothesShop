<?php

abstract class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $templatesRoot = 'views';
    protected $renderer;

    public function __construct()
    {
        $this->renderer = new TemplateRenderer();
    }

    public function run($action)
    {
        if(empty($action)){
            $action = $this->defaultAction;
        } else {
            if(!method_exists(get_class($this), "action" . $action)){
                $action = $this->defaultAction;
            }
        }

        $this->action = $action;
        $action = "action" . ucfirst($this->action);

        $this->$action();

    }

    public function actionIndex()
    {
        echo "Это стартовая страничка";
    }

    protected function render($template, $params = [])
    {
        $templatePath = "{$template}.html.twig";
        echo $this->renderer->render($templatePath, $params);
    }
}