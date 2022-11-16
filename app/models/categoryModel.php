<?php

class CategoryModel{
    private $db;
    
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }
    /** Función que abre la conexión a la base de datos*/
  

    function getAll($order, $orderMode, $elements, $startAt){
        $query = $this->db->prepare ("SELECT * 
                  FROM categorias 
                  ORDER BY $order $orderMode
                  LIMIT $elements
                  OFFSET $startAt");
        
        $query->execute();

        $categories = $query->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }

    function getAllWithFilter($order, $orderMode, $elements, $startAt, $filterBy, $equalTo){
        $query = $this->db->prepare ("SELECT * 
        FROM categorias
        WHERE $filterBy = ? 
        ORDER BY $order $orderMode
        LIMIT $elements
        OFFSET $startAt");

        $query->execute([$equalTo]);
        $categories = $query->fetchAll(PDO::FETCH_OBJ);

        return $categories;
    }


    function getById($id) {

        $query = $this->db->prepare('SELECT * FROM categorias WHERE id = ?');
        $query->execute([$id]);

        $categoria = $query->fetch(PDO::FETCH_OBJ);

        return $categoria;
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

    function getColumns(){
        $query = $this->db->prepare('DESCRIBE categorias');
        $query->execute();

        $columns = $query->fetchAll(PDO::FETCH_OBJ);
        return $columns;
    }
}