<?php 

require_once './libs/Router.php';
require_once './app/Controllers/productsApiController.php';

$router = new Router();

$router->addRoute('products', 'GET', 'productsApiController', 'getProducts');
$router->addRoute('products/:ID', 'GET', 'productsApiController', 'getProduct');
$router->addRoute('products', 'POST', 'productsApiController', 'insertProduct');
$router->addRoute('products/:ID', 'DELETE', 'productsApiController', 'deleteProduct');
$router->addRoute('products/:ID', 'PUT', 'productsApiController', 'updateProduct');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);