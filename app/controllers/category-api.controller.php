<?php 

require_once 'app/models/categoryModel.php';
require_once 'app/views/api-view.php';
//require_once 'app/helpers/AuthHelper.php';


class CategoryApiController{

    private $categoryModel;
    private $view;
    private $data;
    //private $authHelper;

    function __construct(){
        $this->categoryModel = new CategoryModel();
        $this->view = new Apiview();  
        //$this->authHelper = new AuthHelper(); 

        // lee el body del request
        $this->data = file_get_contents("php://input");
}

    private function getBody() {
        return json_decode($this->data);
    }

    /**Obtiene un JSON arreglo de objetos JSON con todas las categorías que existen en la base de datos.
     * Si viene un id por parametro, lo almacena en $id y luego obtiene, del modelo, la categoría correspondiente a ese id.
     */
    function get($params=null){

        // Si vienen parametros, llama al modelo y busca por id
        if ($params != null ) {
            $id = $params[':ID'];

            //Si el $id es numero y mayor que cero, entonces... 
            if(is_numeric($id) && $id>0){            

                /**Obtiene la categoría del modelo correspondiente al id*/
                $result = $this->categoryModel->getById($id);
            
                if ($result) {
                    return $result = $this->view->response($result, 200);
                }
                else {
                    $result = $this->view->response("La categoría con el id $id no existe", 404);
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
            $orderBy = $_GET['orderBy'] ?? "categoria";
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
            if (in_array(strtolower($orderBy), $columns) && (strtolower($orderMode == "asc") || strtolower($orderMode == "desc"))){
            
                // Verifica si los parámetros de paginado son válidos
                if((is_numeric($page) && $page>0) && (is_numeric($elements) && $elements>0)){

                    //Calcula cuál es el primer elemento a mostrar del paginado y lo almacena en $startAt
                    $startAt = ($page*$elements)-$elements;

                    // Verifica si existen los parámetros de filtrado
                    if ($filterBy!=null && $equalTo!=null){

                        //Verifica que el campo $filterBy exista en la tabla (comparando con $columns)
                        if ($filterBy == 'categoria' || in_array(strtolower($filterBy), $columns)){
                            
                            //Obtiene todas las categorías del modelo y pasa los parametros de ordenamiento, paginado y filtrado.
                            $result = $this->categoryModel->getAllWithFilter($orderBy, $orderMode, $elements, $startAt, $filterBy, $equalTo);
                            // var_dump($result);//Verifica si la consulta se realizó correctamente
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
                        
                       //Obtiene todas las categorías del modelo y pasa los parametros de ordenamiento y paginado.
                       $result = $this->categoryModel->getAll($orderBy, $orderMode, $elements, $startAt);
                       $this->view->response($result,200);
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
     
    //Método que devuelve un arreglo con los nombres de las columnas de una tabla
    function getHeaderColumns($params = null) {

        //Se define un arreglo vacío para almacenar los nombres de las columnas.
        $columns = [];

        // Obtiene toda la información de las columnas de la tabla. Devuelve un arreglo de objetos con toda la info
        $result = $this->categoryModel->getColumns();

        //Recorre el arreglo y por cada elemento, extrae el nombre de la columna y lo agrega al arreglo $columns.
        foreach ($result as $column) {
            array_push($columns, $column->Field);
        }
        return $columns;
    }

    function add($params=null) {
        //$this->authHelper->isLoggedIn();
        //$admin = $this->authHelper->checkLoggedIn();
        
        //Se obtiene el JSON con los datos a insertar.
        $body = $this->getBody();
        

        //Si vienen datos vacíos se muestra mensaje de error con código 400. 
        if(empty($body->categoria) || empty($body->segmento)){
            $this->view->response("Complete los datos", 400);
        }
        else {
            //Inserta el JSON en la base de datos y almacena en $id el Id de la categoría insertada.
            $id = $this->categoryModel->addCategory($body->categoria, $body->segmento);
            //Obtiene nuevamente la categoria que acaba de insertar, para mostrarla en la vista.
            $category = $this->categoryModel->getById($id);
            $this->view->response($category, 201);
        }
    }

    function update($params=null) {
        //$this->authHelper->isLoggedIn();
        //$admin = $this->authHelper->checkLoggedIn();

        //Se obtiene el JSON con los datos modificados a insertar.
        $body = $this->getBody();

        if ($params != null){
            $id = $params[':ID'];
           //Obtiene la tarea que se quiere editar.
            $category = $this->categoryModel->getById($id);

            if ($category){
                $this->categoryModel->updateCategory($id, $body);
                $this->view->response('la categoría se actualizó correctamente', 200);
            } else {
                return $this->view->response('La categoría con el id '.$id.' no existe.', 404);
            }
        }     
    }

    function delete($params=null) {
        //$this->authHelper->isLoggedIn();
        //$admin = $this->authHelper->checkLoggedIn();

        if ($params != null){
            $id = $params[':ID'];
        }

        $result = $this->categoryModel->deleteCategory($id);

        $this->view->response($result, 200);
    }

}
