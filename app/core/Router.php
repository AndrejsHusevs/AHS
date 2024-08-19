<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($route, $controllerAction)
    {
        $this->routes['GET'][$route] = $controllerAction;
    }

    public function post($route, $controllerAction)
    {
        $this->routes['POST'][$route] = $controllerAction;
    }

    public function dispatch()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            [$controller, $action] = $this->routes[$method][$uri];
            (new $controller)->$action();
        } else {
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}


?>