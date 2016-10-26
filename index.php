<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'services/Autoloader.php';
spl_autoload_register([new Autoloader(), 'getClass']);

$controller = ucfirst($_REQUEST['c']) . 'Controller';
$action = ucfirst($_REQUEST['a']);

if(class_exists($controller)){
    $c = new $controller();
    $c->run($action);
}