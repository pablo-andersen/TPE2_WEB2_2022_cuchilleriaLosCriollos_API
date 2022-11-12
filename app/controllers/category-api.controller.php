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
        //$admin = $this->authHelper->checkLoggedIn();

        if ($params != null ) {
            $id = $params[':ID'];

            /**Obtiene la categoría del modelo correspondiente al id*/
            $result = $this->categoryModel->getById($id);
        } 
        else {
            $filterBy = $_GET['filterBy'] ?? null;
            $equalTo = $_GET['equalTo'] ?? null;
            $orderBy = $_GET['orderBy'] ?? null;
            $orderMode = $_GET['orderMode'] ?? null;
            /**Obtiene todas las categorías del modelo y pasa los parametros de filtrado y ordenamiento*/
            $result = $this->categoryModel->getAll($filterBy, $equalTo, $orderBy, $orderMode);            
        }

        /**Envía la/s categoría/s a la vista para ser mostrada/s */
        $this->view->response($result, 200);
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
