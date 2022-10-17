<?php

class UserModel {

    private $db;
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }
    
    function getUser($email){
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}