<?php

class HomeView{


    function showHome($admin, $user=NULL){
        $smarty = new Smarty();
        $smarty->assign('isAdmin', $admin);
        $smarty->assign('user', $user);
        $smarty->display('templates/header.tpl');
        $smarty->display('templates/home.tpl');
        $smarty->display('templates/footer.tpl');    
    }

    function showLoginLocation(){
        header('Location:'.BASE_URL.'login');
    }

}
