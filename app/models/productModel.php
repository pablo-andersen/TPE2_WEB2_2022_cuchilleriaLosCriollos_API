<?php

class ProductModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }

    function getAll($order, $orderMode, $elements, $startAt){
        $query = $this->db->prepare("SELECT productos.*, categorias.categoria 
        FROM productos 
        JOIN categorias 
        ON productos.id_categoria = categorias.id 
        ORDER BY $order  $orderMode
        LIMIT $elements 
        OFFSET $startAt");
        
        $query->execute();

        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;

    }

    function getAllWithFilter($order, $orderMode, $elements, $startAt, $filterBy, $equalTo){
        $query = $this->db->prepare("SELECT productos.*, categorias.categoria 
                                     FROM productos
                                     JOIN categorias
                                     ON productos.id_categoria = categorias.id 
                                     WHERE $filterBy = ?
                                     ORDER BY $order $orderMode
                                     LIMIT $elements 
                                     OFFSET $startAt");

        $query->execute([$equalTo]);
        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    function getById($id){

        $query = $this->db->prepare ('SELECT productos.*, categorias.categoria FROM productos JOIN categorias ON productos.id_categoria = categorias.id WHERE productos.id = ?');
        $query->execute([$id]);

        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }
    function addProduct($product){
        $query = $this->db->prepare('INSERT INTO productos (nombre, descripcion, imagen, precio, id_categoria) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$product->nombre, $product->descripcion, $product->imagen, $product->precio, $product->id_categoria]);
        return $this->db->lastInsertId();
    }

    function updateProduct($id, $product){
        $query = $this->db->prepare('UPDATE productos SET nombre = ?, descripcion = ?, imagen = ?, precio = ?, id_categoria = ? WHERE id = ?');
        $query->execute([$product->nombre, $product->descripcion, $product->imagen, $product->precio, $product->id_categoria, $id]);
    }

    function getColumns(){
        $query = $this->db->prepare('DESCRIBE productos');
        $query->execute();

        $columns = $query->fetchAll(PDO::FETCH_OBJ);
        return $columns;
    }

}