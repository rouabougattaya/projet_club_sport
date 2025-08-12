<?php

class Router
{
    public static function route()
    {
        $controllerName = $_GET['controller'] ?? 'user';
        $action = $_GET['action'] ?? 'index';

        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass();

            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                echo "Action '$action' non trouvée.";
            }
        } else {
            echo "Contrôleur '$controllerName' non trouvé.";
        }
       
    }
}
