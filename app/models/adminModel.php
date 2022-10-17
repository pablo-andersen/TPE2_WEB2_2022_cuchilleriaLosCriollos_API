<?php

class AdminModel{
    private $db;
    /** Función que abre la conexión a la base de datos*/
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=cuchilleria_los_criollos;charset=utf8', 'root', '');
    }

    


}