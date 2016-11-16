<?php

/**
 * Class Controller
 */
abstract class Controller
{
    protected $name;
    protected $action;
    protected $defaultAction = 'index';
    protected $layoutsRoot = 'layouts';
    protected $layout = 'main';
    protected $useLayout = true;
    protected $renderer;

    public function __construct()
    {
        $this->renderer = new TemplateRenderer();
        $this->name = substr(static::class, 0, -10);
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

    /**
     * Действие, выполняемое по умолчанию
     * @return mixed
     */
    abstract public function actionIndex();

    protected function render($template, $params = [])
    {
        $templatePath = "{$this->name}/{$template}";
        if($this->useLayout){
            $content = $this->renderTemplate($templatePath, $params);
            $layout = $this->layoutsRoot . '/' . $this->layout;
            echo $this->renderTemplate($layout, ['content' => $content]);
        } else {
            echo $this->renderTemplate($templatePath, $params);
        }

    }

    protected function renderTemplate($template, $params = [])
    {
        $templatePath = "{$template}.html.twig";
        return $this->renderer->render($templatePath, $params);
    }
}