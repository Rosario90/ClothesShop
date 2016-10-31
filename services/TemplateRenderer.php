<?php
class TemplateRenderer
{
    protected $templateDir;
    protected $templater;

    public function __construct()
    {
        $this->templateDir = $_SERVER['DOCUMENT_ROOT'] . "/ClothesShop/views";
        $loader = new Twig_Loader_Filesystem($this->templateDir);
        $this->templater = new Twig_Environment($loader);
    }

    public function render($template, $params)
    {
        $template = $this->templater->loadTemplate($template);
        return $template->render($params);
    }
}