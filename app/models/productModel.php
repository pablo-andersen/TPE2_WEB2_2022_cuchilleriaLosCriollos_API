<?php

class ProductModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }

    function getAll(){

        $query = $this->db->prepare('SELECT productos.*, categorias.categoria FROM productos JOIN categorias ON productos.id_categoria = categorias.id');
        $query->execute();

        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    function getById($id){


        //$query = $this->db->prepare('SELECT * FROM productos WHERE id = '.$id);
        $query = $this->db->prepare ('SELECT productos.*, categorias.categoria FROM productos JOIN categorias ON productos.id_categoria = categorias.id WHERE productos.id = ?');
        $query->execute([$id]);

        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }
    function addProduct($product){
        $query = $this->db->prepare('INSERT INTO productos (nombre, descripcion, imagen, precio, id_categoria) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$product->nombre, $product->descripcion, $product->imagen, $product->precio, $product->id_categoria]);
    }

    function updateProduct($product){
        $query = $this->db->prepare('UPDATE productos SET nombre = ?, descripcion = ?, imagen = ?, precio = ?, id_categoria = ? WHERE id = ?');
        $query->execute([$product->nombre, $product->descripcion, $product->imagen, $product->precio, $product->id_categoria, $product->id]);
    }

    function deleteProduct($id) {
        $query = $this->db->prepare('DELETE FROM productos WHERE productos.id = ?');
        $query->execute([$id]);
    }

}