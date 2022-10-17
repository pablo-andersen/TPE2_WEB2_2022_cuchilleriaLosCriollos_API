<?php

class LoginView{
    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showLogin($admin, $error = ""){
        $this->smarty->assign('error',$error);
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->display('templates/header.tpl');
        $this->smarty->display('templates/login.tpl');
        $this->smarty->display('templates/footer.tpl');
    }

    function showHome(){
        header('Location: '.BASE_URL.'home');
    }
}