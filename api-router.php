<?php

//incluyo controllers y libs que seran necesarios.
require_once './libs/Router.php';
require_once 'app/controllers/category-api.controller.php';
require_once 'app/controllers/product-api.controller.php';

//Se define la base de la URL para utilizar PrettyURL
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

//Instancio el router de la libreria
$router = new Router();


//  ** DEFINO MI TABLA DE RUTEO **

//Listar todas las categorias
$router->addRoute('categories', 'GET', 'CategoryApiController', 'get');
//obtener una categoría en especial. Le debo pasar un id en el parámetro
$router->addRoute('categories/:ID', 'GET', 'CategoryApiController', 'get');
//Insertar una categoria
$router->addRoute('categories', 'POST', 'CategoryApiController', 'add');
//Editar una categoria. Le debo pasar un id en el parámetro
$router->addRoute('categories/:ID', 'PUT', 'CategoryApiController', 'update');
//Listar todos los productos
$router->addRoute('products', 'GET', 'ProductApiController', 'get');
//Obtener un producto. Le debo pasar un parámetro
$router->addRoute('products/:ID', 'GET', 'ProductApiController', 'get');
//Insertar un producto.
$router->addRoute('products', 'POST', 'ProductApiController', 'add');
//Editar un producto. Le debo pasar un parámetro
$router->addRoute('products/:ID', 'PUT', 'ProductApiController', 'update');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);