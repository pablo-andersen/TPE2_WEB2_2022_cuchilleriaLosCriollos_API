<?php

class CategoryModel{
    private $db;
    
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }
    /** Función que abre la conexión a la base de datos*/
  

    function getAll($filterBy, $equalTo, $orderBy, $orderMode){
        $query = 'SELECT * FROM categorias';
        if ($filterBy) {
            $query = $query . ' WHERE = ' . $filterBy . ' = ' . $equalTo;
        }
        if ($orderBy){
            $query = $query . ' ORDER BY ' . $orderBy;
        }
        if ($orderMode) {
            $query = $query . ' ' . $orderMode;
        }
        $queryDB = $this->db->prepare($query);
        $queryDB->execute();

        $categories = $queryDB->fetchAll(PDO::FETCH_OBJ);

        return $categories;
    }

    function getById($id) {

        $query = $this->db->prepare('SELECT * FROM categorias WHERE id = ?');
        $query->execute([$id]);

        $categoria = $query->fetch(PDO::FETCH_OBJ);

        return $categoria;
    }

    function getCategoryDetails($id){

        $query = $this->db->prepare('SELECT * FROM productos WHERE id_categoria = ?');
        $query->execute([$id]);

        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }
    
    function addCategory($categoria, $segmento) {
        $query = $this->db->prepare("INSERT INTO categorias (categoria, segmento) VALUES (?, ?)");
        $query->execute([$categoria, $segmento]);

        return $this->db->lastInsertId();
    }

    function updateCategory($id, $category) {
        $query = $this->db->prepare('UPDATE categorias SET categoria = ?, segmento = ? WHERE categorias.id = ?');
        $query->execute([$category->categoria, $category->segmento, $id]);
    }

    function deleteCategory($id){
        try {
            $query = $this->db->prepare('DELETE FROM categorias WHERE categorias.id = ?');
            $query->execute([$id]);
            $result = "El registro fue eliminado correctamente.";
            return $result;
        }
        catch (Exception $e){
            $result = "No se pudo eliminar la categoría seleccionada. Para poder hacerlo, no debe existir ningún producto asociado a esta categoría.";
            return $result;
            die;
        }
        
    }
}