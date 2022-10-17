<?php

class AdminView{


    function showConsole(){
        $smarty = new Smarty();
        $smarty->display('templates/header.tpl');
        $smarty->display('templates/adminConsole.tpl');
        $smarty->display('templates/footer.tpl');    
    }

}