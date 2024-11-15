<?php

use Dotenv\Dotenv;
use Core\Router;

session_start();
const BASE_PATH = __DIR__;
require('./module.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
require('./routes.php');

$parsedUrl = parse_url($_SERVER['REQUEST_URI'])['path'];
$uri = substr($parsedUrl, strpos($parsedUrl, "/", 1));

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (Error $err) {
    var_dump($err);
}















