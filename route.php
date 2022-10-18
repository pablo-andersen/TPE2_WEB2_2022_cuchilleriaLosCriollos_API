<?php

//Se incluyen los controladores, que serán necesarios en el switch/case
require_once 'libs/smarty/libs/Smarty.class.php';
require_once 'app/controllers/categoryController.php';
require_once 'app/controllers/productController.php';
require_once 'app/controllers/loginController.php';
require_once 'app/controllers/homeController.php';

//Se define la base de la URL para utilizar PrettyURL
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

//Se lee la acción que trae el endpoint, si no está seteado se asigna por defecto el valor 'home'
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home'; // acción por defecto si no envían
}

$categoryController = new CategoryController();
$productController = new ProductController();
$loginController = new LoginController();
$homeController = new HomeController();


//Se parsea la variable $accion para armar la URL semántica **/
$params = explode('/', $action); 

//Se determina que camino seguir según la acción parseada en $accion
//**/
switch ($params[0]) {
    case 'home':
            $homeController->showHome();
        break;
    case 'product':
        if (isset($params[1])) {
            switch($params[1]){
                case 'list':
                    $productController->showProducts();
                    break;
                case 'detail':
                    $productController->showProductById($params[2]);
                    break;
                case 'add':
                    $productController->showAddProduct();
                    break;
                case 'insert':
                    $productController->addProduct();
                    break;
                case 'edit':
                    $productController->editProduct($params[2]);
                    break;
                case 'update':
                    $productController->updateProduct($params[2]);
                    break;
                case 'delete':
                    $productController->deleteProduct($params[2]);
                    break;
                default:
                    echo ('404 Page not found');
                    break;
            }
        } 
        else {
            echo ('404 Page not found');
        }
        break;
    case 'category':
        if (isset($params[1])) {
            switch($params[1]){
                case 'list':
                    $categoryController->showCategories();
                    break;
                case 'detail':
                    $categoryController->showCategoryContent($params[2]);
                    break;
                case 'add':
                    $categoryController->showAddCategory();
                    break;
                case 'insert':
                    $categoryController->addCategory();
                    break;
                case 'edit':
                    $categoryController->editCategory($params[2]);
                    break;
                case 'update':
                    $categoryController->updateCategory($params[2]);
                    break;
                case 'delete':
                        $categoryController->deleteCAtegory($params[2]);
                        break;
                case 'default':
                    echo ('404 Page not found');
                    break;
            }
        }
        else {
            echo ('404 Page not found.');
        }
        break;
    case 'login':
        $loginController->showLogin();
        break;
    case 'verify':
        $loginController->verifyLogin();
        break;
    case 'logout':
        $loginController->logout();
        break;
    default:
        echo ('404 Page not found');
        break;
}

