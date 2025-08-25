<?php

class Router
{
    public static function route()
    {
        $controllerName = $_GET['controller'] ?? null;
        $action = $_GET['action'] ?? 'index';

        // Si aucun contrôleur n'est spécifié et qu'un utilisateur est connecté
        if ($controllerName === null) {
            if (!empty($_SESSION['user'])) {
                // Rediriger vers le dashboard
                header('Location: index.php?controller=dashboard&action=index');
                exit;
            } else {
                // Rediriger vers la page de connexion
                header('Location: index.php?controller=auth&action=login');
                exit;
            }
        }

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
