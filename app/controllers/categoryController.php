<?php

require_once 'app/models/categoryModel.php';
require_once 'app/views/categoryView.php';
require_once 'app/helpers/AuthHelper.php';

class CategoryController{

    private $categoryModel;
    private $categoryView;
    private $authHelper;

    function __construct(){
        $this->categoryModel = new CategoryModel();
        $this->categoryView = new CategoryView();  
        $this->authHelper = new AuthHelper(); 
    }

    /**Obtiene una lista de las categorías que existen en la base de datos. Se utiliza en la visualización del home */
    function showCategories(){
        $admin = $this->authHelper->checkLoggedIn();
        /**Obtiene las categorías del modelo */
        $categories = $this->categoryModel->getAll();

        /**Envía las categorías a la vista para ser mostradas */
        $this->categoryView->showAll($categories, $admin);
    }

    function showCategoryContent($id) { // %$url = 1
        //$this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        /**Obtiene del modelo la categoría pasada por parámetro */
        $productsByCategory = $this->categoryModel->getCategoryDetails($id);

        /**Envía el registro completo a la vista para mostrar los detalles de la categoría pasada por parámetro */
        $this->categoryView->showProductsByCategory($productsByCategory, $admin);
    }

    
    function showAddCategory(){   
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        $categories = $this->categoryModel->getAll();
        $this->categoryView->showAdminCategories($categories, $admin);
    }

    function addCategory() {
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        if ($admin) {
            if((isset($_POST)) && (!empty($_POST["category"])) && (isset($_POST["segment"]))){
                $category = $_POST['category'];
                $segment = $_POST['segment'];
                $this->categoryModel->addCategory($category, $segment, $admin);
                $this->showCategories();
            }
            else {
                echo 'ERROR: Complete todos los campos del formulario para ingresar los datos.';
            }
        }
        else 
            header('Location'.BASE_URL.'login');
        
    }

    function editCategory($id) {
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        $categoryToUpdate = $this->categoryModel->getById($id);
        $categories = $this->categoryModel->getAll();
        $this->categoryView->ShowEditCategory($categoryToUpdate, $categories, $admin);

    }

    function updateCategory($id) {
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        $category = $_POST['category'];
        $segment = $_POST['segment'];
        $this->categoryModel->updateCategory($id, $category, $segment, $admin);
        $this->showCategories();
    }

    function deleteCAtegory($id) {
        $this->authHelper->isLoggedIn();
        $this->categoryModel->deleteCategory($id);
        $this->showCategories();
    }
    
}
