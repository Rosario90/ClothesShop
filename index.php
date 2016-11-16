<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'services/Autoloader.php';
spl_autoload_register([new Autoloader(), 'getClass']);
require_once 'vendor/autoload.php';

$controller = new FrontController;
$controller->run();