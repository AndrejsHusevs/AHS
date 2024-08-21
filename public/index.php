<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// MYDEBUG
// echo '<span style="background-color: lightgreen;  margin-right: 20px;">AHS 0.1</span>';

require_once __DIR__ . '/../vendor/autoload.php';

use app\Core\Router;
use app\Controllers\GraphQL;
use app\Controllers\SiteController;
use app\Controllers\TestFormGraphQLController;


// Capture the requested URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// MYDEBUG
//echo 'requestUri='.$requestUri.'<br/><hr>';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    //echo 'myr='.$r;
    $r->get('', [SiteController::class, 'index']);
    $r->get('/', [SiteController::class, 'index']);
    $r->get('/ahs/', [SiteController::class, 'index']);
    $r->get('/testFormGraphQL', [TestFormGraphQLController::class, 'index']);
    $r->get('/ahs/testFormGraphQL', [TestFormGraphQLController::class, 'index']);
    $r->post('/graphql', [GraphQL::class, 'handle']);    
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
        echo "<p>The requested URL <strong>$requestUri</strong> was not found on this server.</p>";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo "405 - Method Not Allowed";
        echo "<p>The requested URL <strong>$requestUri</strong> does not allow the method used.</p>";
        echo "<p>Allowed methods: " . implode(', ', $allowedMethods) . "</p>";
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




