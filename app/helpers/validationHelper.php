<?php

class validationHelper {
function getHeaderColumns($params=null){
    $columns = [];
    $result = $this->productModel->getColumns();
    //var_dump($result);
    foreach ($result as $columna) {
        // var_dump($columna->Field);
        array_push($columnas, $columna->Field);
    }
    $this->view->response($columnas, 200);
}
}