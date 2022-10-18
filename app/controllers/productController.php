<?php

require_once 'app/models/productModel.php';
require_once 'app/models/categoryModel.php';
require_once 'app/views/productView.php';
require_once 'app/helpers/AuthHelper.php';

class ProductController{

    private $productModel;
    private $productView;
    private $categoryModel;
    private $authHelper;

    function __construct(){
        $this->productModel = new ProductModel();
        $this->productView = new ProductView();
        $this->categoryModel = new CategoryModel();
        $this->authHelper = new AuthHelper(); 
    }

    /*Obtiene una lista de los productos que existen en la base de datos. */
    function showProducts(){
        $admin = $this->authHelper->checkLoggedIn();
        /**Obtiene todos los productos del modelo */
        $allProducts = $this->productModel->getAll();

        /**Envía los productos a la vista para ser mostradas */
        $this->productView->showAll($allProducts, $admin);
    }

    function showProductById($id) {
        $admin = $this->authHelper->checkLoggedIn();
        
        /**Obtiene del modelo el detalle del producto pasado por parámetro */
        $product = $this->productModel->getById($id);

        /**Envía el registro completo a la vista para mostrar los detalles del producto*/
        $this->productView->showById($product, $admin);
    }

    function showAddProduct(){
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();        
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $this->productView->showAdminProducts($products,$categories, $admin);
            //Muestra una seccion con formulario para ingresar productos 
            //y debajo el listado de los productos, con botones para editar y eliminar.
    }
    
    function addProduct(){
        $this->authHelper->isLoggedIn();
        // Proceso la imagen recibida del formulario en el arreglo $_FILES, para subirla a la base de datos (campo de tipo LONGBLOB)
        $imagen_subida = 'uploaded_files/'. uniqid() . basename($_FILES['imagen']['name']); 
        $type= $_FILES['imagen']['type'];
        //Valido que el archivo se haya cargado correctamente y sea una imagen válida.
        if ((move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_subida)) && ($type == "image/jpeg" || $type == "image/jpg" || $type == "image/png" || $type == "image/gif")) {
            // Creo un nuevo objeto donde almacenar la info que viene del formulario para enviar a insertar el registro en la DB
            $product = new stdClass();            
            // En el objeto guardo la info de $_POST y la imagen procesada previamente de $_FILES que vinieron del formulario
            $product->nombre = $_POST['nombre'];
            $product->descripcion = $_POST['descripcion'];
            $product->imagen = $imagen_subida;
            $product->precio = (double)$_POST['precio'];
            $product->id_categoria = (int)$_POST['id_categoria'];
            // Paso el objeto $product al modelo, para insertar el registro en la DB
            $this->productModel->addProduct($product);
            $this->showProducts();
        }
        else {
            echo 'ERROR: Verifique que el archivo que quiso cargar sea una imagen y que no sea muy pesada.';
        }
    }


    function editProduct($id){
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        if ($admin) {
        $productToUpdate = $this->productModel->getById($id);
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $this->productView->showUpdateProduct($productToUpdate, $products,$categories, $admin);
        }
        else
            header('Location:'.BASE_URL.'login');
    }

    function updateProduct($id){
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        $product = new stdClass();            
        // En el objeto guardo la info de $_POST y la imagen procesada previamente de $_FILES que vinieron del formulario
        $product->id = $id;
        $product->nombre = $_POST['nombre'];
        $product->descripcion = $_POST['descripcion'];
        $product->precio = (double)$_POST['precio'];
        $product->id_categoria = (int)$_POST['id_categoria'];

        if (!empty($_FILES) && 
                            ($_FILES['imagen']['type'] == "image/jpeg" || 
                            $_FILES['imagen']['type'] == "image/jpg" || 
                            $_FILES['imagen']['type'] == "image/png" || 
                            $_FILES['imagen']['type'] == "image/gif")) {
            // Proceso la imagen recibida del formulario en el arreglo $_FILES, para subirla a la base de datos (campo de tipo LONGBLOB)
            $imagen_subida = 'uploaded_files/' . basename($_FILES['imagen']['name']);
            //Valido que el archivo se haya cargado correctamente y sea una imagen válida.
            move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_subida);
            // Creo un nuevo objeto donde almacenar la info que viene del formulario para enviar a insertar el registro en la DB 
            $product->imagen = $imagen_subida;
        }
        else {
            $product->imagen = $_POST['imagenAnterior'];
        }
                
            // Paso el objeto $product al modelo, para insertar el registro en la DB
            $this->productModel->UpdateProduct($product);
            $this->showProducts();
    }

    function deleteProduct($id) {
        $this->authHelper->isLoggedIn();
        $admin = $this->authHelper->checkLoggedIn();
        if ($admin) {
            $this->productModel->deleteProduct($id);
            $this->showProducts();
        }
        else {
            header('Location:'.BASE_URL.'login');
        }
    }
}