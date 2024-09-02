<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\GraphQL;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->post('/graphql', [App\Controller\GraphQL::class, 'handle']);
    $r->post('/ahs/graphql', [GraphQL::class, 'handle']); 

});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);



switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['error' => 'Not Found', 'url' => $_SERVER['REQUEST_URI']]);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        echo $handler($vars);
        break;
}