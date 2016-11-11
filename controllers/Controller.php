<?php

abstract class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $templatesRoot = 'views';
    protected $layoutsRoot = 'layouts';
    protected $layout = 'main';
    protected $useLayout = true;
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
        if($this->useLayout){
            $content = $this->renderTemplate($template, $params);
            $layout = $this->layoutsRoot . '/' . $this->layout;
            echo $this->renderTemplate($layout, ['content' => $content]);
        } else {
            echo $this->renderTemplate($template, $params);
        }

    }

    protected function renderTemplate($template, $params = [])
    {
        $templatePath = "{$template}.html.twig";
        return $this->renderer->render($templatePath, $params);
    }
}