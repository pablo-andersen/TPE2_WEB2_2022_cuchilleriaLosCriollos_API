<?php

class CategoryView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showAll($categories, $admin){
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('templates/showAllCategories.tpl');
    }


    function showProductsByCategory($productsByCategory, $admin){
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->assign('productsByCategory',$productsByCategory);
        $this->smarty->display('showProductsByCategory.tpl');
    }
    
    function showAdminCategories($categories,$admin){
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('adminCategories.tpl');
    }
    
    function showEditCategory($category, $categories, $admin){
        $this->smarty->assign('isAdmin', $admin);
        $this->smarty->assign('category', $category);
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('editCategory.tpl');
    }

    
    function showResult($admin, $result, $link){
        $this->smarty->assign('isAdmin', $admin);
        $this->smarty->assign('result', $result);
        $this->smarty->assign('link', $link);
        $this->smarty->display('showResult.tpl');
    }
    
}