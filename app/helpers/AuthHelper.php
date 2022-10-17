<?php

class AuthHelper {

    function checkLoggedIn(){
        if(session_status()!= PHP_SESSION_ACTIVE){
        session_start();
        }
        if (!isset($_SESSION['email'])) {
            return false;
        }
        else {
            return true;
        }
    }

    function isLoggedIn(){
        session_start();
        if(!isset($_SESSION['email'])){
            header('Location:'.BASE_URL.'login');
            die();
        }
    }

    function logout(){
        session_destroy();
        header('Location:'.BASE_URL.'home');
    }
}