<?php

// MYDEBUG
// echo '<span style="background-color: lightgreen;  margin-right: 20px;">AHS 0.1</span>';

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\SiteController;
use App\Controllers\TestFormGraphQLController;
use App\Controllers\GraphQL;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/ahs/', [SiteController::class, 'index']);
    $r->get('/ahs/testFormGraphQL', [TestFormGraphQLController::class, 'index']);
    $r->post('/ahs/graphql', [GraphQL::class, 'handle']);    
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// MYDEBUG
//echo '<span style="background-color: lightgreen; margin-right: 20px;">'.print_r($routeInfo, true).'</span>';

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "404 - Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo "405 - Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // MYDEBUG
        //echo '<span style="background-color: lightgreen; margin-right: 20px;">Handler: '.print_r($handler, true).'</span>';
        //echo '<span style="background-color: lightgreen; margin-right: 20px;">Vars: '.print_r($vars, true).'</span>';

        // Call the appropriate controller action
        $controller = new $handler[0]();
        echo call_user_func_array([$controller, $handler[1]], $vars);

        break;
}




