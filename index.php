<?php

define('ROOT', __DIR__);
require_once(ROOT . '/vendor/autoload.php');

$router = new Components\Router();
$router->run();



