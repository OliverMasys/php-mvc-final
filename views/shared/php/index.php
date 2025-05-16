<?php

declare(strict_types=1);

define("WEB_ROOT", "/webdev/JimBelushi/php/");
define('ROOT_PATH', __DIR__);

$base_url = WEB_ROOT;

use Framework\Exceptions\PageNotFoundException;

// Catches error information then passes it to the ErrorException function
set_error_handler(function(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
): bool
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});



// Calls the custom exception handler
set_exception_handler(function (Throwable $exception) {

    if ($exception instanceof Framework\Exceptions\PageNotFoundException) {

        http_response_code(404);

        $template = "404.php";

    } else {
    
        http_response_code(500);

        $template = "500.php";

    }

    $show_errors = true;

    if ($show_errors) {

        ini_set("display_errors", "1");

        require ROOT_PATH . "/views/$template";

    } else {

        ini_set("display_errors", "0");

        ini_set("log_errors", "1");

        require ROOT_PATH . "/views/$template";

    }

    throw $exception;

});



// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //this is the original URL parser
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// remove the directory path the script resides in (if any)
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptDir, '/');

// remove base path from URI
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// ensure it starts with a forward slash
$path = '/' . ltrim($uri, '/');

// include the router file with the Router class definition
//require "src/router.php";

spl_autoload_register( function (string $class_name) {

    require ROOT_PATH . "/src/" . str_replace("\\", "/", $class_name) . ".php";
});

// add these lines to your code
$dotenv = new Framework\Dotenv;

$dotenv->load(ROOT_PATH . "/.env");

 //print_r($_ENV);

// create a new Router object from the Router class
$router = new Framework\Router;

// begin adding routes to the $routes array
$router->add("/", ["controller" => "home", "action" => "index"]);
$router->add("/home/index", ["controller" => "home", "action" => "index"]);

$router->add("/products/new", ["controller" => "products", "action" => "new"]);
$router->add("/products/create", ["controller" => "products", "action" => "create"]);

$router->add("/products/{id:\d+}/show", ["controller" => "products", "action" => "show"]);
$router->add("/product/{slug:[\w-]+}", ["controller" => "products", "action" => "show"]);

$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/products/index", ["controller" => "products", "action" => "index"]);

$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/{controller}/{action}");

// call to matchRoute() to return an array of $params from $routes
$params = $router->matchRoute($path);

// check for non-existent route
if ($params === false) {

    throw new PageNotFoundException("No matching route for '$path'.");

}

// Check if 'id' param exists
if (!empty($params["id"])) {
    $id = $params["id"];
} else {
    $id = null;
}

// edit these variables to assign values from $params array from Router class
$controller = $params["controller"];
$action = $params["action"];

// require the necessary controller using the variable value
//require "src/controllers/$controller.php";
$controller = "App\Controllers\\" . ucwords($params["controller"]);

// assign the name of the desired controller to a $controller_object variable
$controller_object = new $controller;

// call the method from the controller using the $action value
//$controller_object->$action();
if ($id !== null) {
    $controller_object->$action($id);
} else {
    $controller_object->$action();
}