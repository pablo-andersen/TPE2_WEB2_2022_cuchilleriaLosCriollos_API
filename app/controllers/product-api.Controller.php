<?php

require_once 'app/models/productModel.php';
require_once 'app/models/categoryModel.php';
require_once 'app/views/api-view.php';

class ProductApiController{

    private $productModel;
    private $view;
    private $data;

    function __construct(){
        $this->productModel = new ProductModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");        
    }

    private function getBody() {
        return json_decode($this->data);
    }

    /**Si no viene un id por parámetro, obtiene un JSON arreglo de objetos JSON con todos los productos que existen en la base de datos.
     * Si viene un id por parametro, lo almacena en $id y luego obtiene, del modelo, el producto correspondiente a ese id.
     */
    function get($params=null){

        // Si vienen parametros, llama al modelo y busca por id
        if($params!=null){
            $id=$params[':ID'];

            //Si el $id es numero y mayor que cero, entonces... 
            if(is_numeric($id) && $id>0){            

                //Obtiene del modelo el producto correspondiente al id. 
                $result = $this->productModel->getById($id);

                if ($result) {
                    return $result = $this->view->response($result, 200);
                }
                else {
                    $result = $this->view->response("El producto con el id $id no existe", 404);
                }
            }
            else {
                $result = $this->view->response("Parámetro no válido.", 400);
            }
        }
        else {
            // no viene un parámetro :ID, entonces obtiene la coleccion entera segun parámetros enviados 
            // mediante $_GET.
            // Asigna los parámetros $_GET en variables. Si no existen, asigna valores por defecto
            // a las variables decalaradas.
            
            // Parámetros de ordenado
            $orderBy = $_GET['orderBy'] ?? "nombre";
            $orderMode = $_GET['orderMode'] ?? "asc";
            
            // Parámetros de paginado
            $page = (int)($_GET['page'] ?? 1);
            $elements = (int)($_GET['elements'] ?? 5);

            // Parámetros de filtrado
            $filterBy = $_GET['filterBy'] ?? null;
            $equalTo = $_GET['equalTo'] ?? null;

            //Obtiene los nombres de las columnas de la tabla productos y los almacena en el arreglo $columns.
            $columns = $this->getHeaderColumns();

            // Verifica si los parámetros de ordenado son válidos
            if (($orderBy == 'categoria' || in_array(strtolower($orderBy), $columns)) && (strtolower($orderMode == "asc") || strtolower($orderMode == "desc"))){

                //Asigna un valor $order para pasar al modelo en funcion del campo por el que se quiere ordenar
                if ($orderBy == 'categoria') {
                    $order = 'categorias.categoria';
                }
                else {
                    $order = 'productos.'.$orderBy;
                }
                // Verifica si los parámetros de paginado son válidos
                if((is_numeric($page) && $page>0) && (is_numeric($elements) && $elements>0)){

                    //Calcula cuál es el primer elemento a mostrar del paginado y lo almacena en $startAt
                    $startAt = ($page*$elements)-$elements;

                    // Verifica si existen los parámetros de filtrado
                    if ($filterBy!=null && $equalTo!=null){

                        //Verifica que el campo $filterBy exista en la tabla (comparando con $columns)
                        if ($filterBy == 'categoria' || in_array(strtolower($filterBy), $columns)){

                            //Asigna un valor $filter para pasar al modelo en funcion del campo por el que se quiere ordenar
                            if ($filterBy == 'categoria') {
                                $filter = 'categorias.categoria';
                            }
                            else {
                                $filter = 'productos'.$filterBy;
                            }
                            
                            //Obtiene todos los productos del modelo y pasa los parametros de ordenamiento, paginado y filtrado.
                            $result = $this->productModel->getAllWithFilter($order, $orderMode, $elements, $startAt, $filter, $equalTo);

                            //Verifica si la consulta se realizó correctamente
                            if(isset($result)){

                                //Verifica si el resultado de la consulta está vacío.
                                if (empty($result)) {
                                    $this->view->response("La consulta realizada no arrojó resultados", 204);
                                }
                                else {

                                    //Envía el/los producto/s a la vista para ser mostrado/s.
                                    $this->view->response($result, 200);
                                }
                            }
                            else {

                                //Informa error interno de servidor
                                $result = $this->view->response("No se pudo realizar la consulta especificada.", 500);
                            }                            
                        }
                        else {

                            //Informa error de parámetro no válido
                            $result = $this->view->response("Parámetro de filtrado no válido.", 400);
                        }                        
                    }
                    else {

                       //Obtiene todos los productos del modelo y pasa los parametros de ordenamiento y paginado.
                        $result = $this->productModel->getAll($order, $orderMode, $elements, $startAt);
                        if (empty($result)) {
                            $this->view->response("La consulta realizada no arrojó resultados", 204);
                        }
                        else {
                            $this->view->response($result,200);
                        }
                    }                    
                }  
                else {
                    //Informa error de parámetro no válido
                    $result = $this->view->response("Parámetro de paginado no válido.", 400);       
                }
            }
            else {

                //Informa error de parámetro no válido
                $result = $this->view->response("Parámetro de ordenamiento no válido", 400);
            }
        }
    }

    function add($params=null){
           
        //Se obtiene el JSON con los datos a insertar.
        $body = $this->getBody();
        
        //Verifica que el JSON ingresado no contenga campos vacíos. 
        if (empty($body->nombre) || 
            empty($body->descripcion) || 
            empty($body->imagen) || 
            empty($body->precio) || 
            empty($body->id_categoria)){
            $this->view->response("Complete los datos", 400);
        }
        else {
            //Inserta el JSON en la base de datos y almacena en $id el Id del producto insertado.
            $id = $this->productModel->addProduct($body);
            //Obtiene nuevamente el producto que acaba de insertar, para mostrarlo en la vista.
            $product = $this->productModel->getById($id);
            $this->view->response($product, 201);            
        }           
    }

    function update($params=null){
        //se obtiene el JSON con los datos modificados a insertar.
        $body = $this->getBody();
        
        if ($params!=null){
            $id = $params[':ID'];

            //Obtiene el producto que se quiere editar. 
            $product = $this->productModel->getById($id);

            if ($product){
                $this->productModel->updateProduct($id, $body);
                $this->view->response('El producto se actualizó correctamente', 200);
            }
            else {
                return $this->view->response('El producto con el id '.$id.' no existe.', 404);
            }
        }
        else {
            $this->view->response('Faltan parámetros. Por favor indique el id de la tarea a modificar.', 400);
        }
    }
    
    //Método que devuelve un arreglo con los nombres de las columnas de una tabla
    function getHeaderColumns($params = null) {

        //Se define un arreglo vacío para almacenar los nombres de las columnas.
        $columns = [];

        // Obtiene toda la información de las columnas de la tabla. Devuelve un arreglo de objetos con toda la info
        $result = $this->productModel->getColumns();

        //Recorre el arreglo y por cada elemento, extrae el nombre de la columna y lo agrega al arreglo $columns.
        foreach ($result as $column) {
            array_push($columns, $column->Field);
        }
        return $columns;
    }
    
}
