<?php

namespace Components;

use Controllers\ErrorPageController;

class Router
{
    private array $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = require($routesPath);
    }

    public function run()
    {
        $success = false;
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $uriPattern => $data) {
            $uriPattern = '^' . $uriPattern . '$';
            if (preg_match("~$uriPattern~", $uri)) {
                if (strtolower($_SERVER['REQUEST_METHOD']) != strtolower($data['http_method'])) {
                    continue;
                }
                $controllerName = $data['controller'];
                if (class_exists($controllerName)) {
                    $controllerObject = new $controllerName;
                    $actionName = $data['action'];
                    if (method_exists($controllerObject, $actionName)) {
                        $controllerObject->$actionName();
                        $success = true;
                        break;
                    }
                }
            }
        }
        if (!$success) {
            $errorPageControllerObject = new ErrorPageController();
            $errorPageControllerObject->view();
        }
    }
}

