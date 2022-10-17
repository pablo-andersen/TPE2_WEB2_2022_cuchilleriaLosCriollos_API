<?php

class ProductView{
    
    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

	function showAll($products, $admin){
        $this->smarty->assign('isAdmin',$admin);
		$this->smarty->assign('products',$products);
		$this->smarty->display('showAllProducts.tpl');
	}

     
	function showById($product, $admin){
        $this->smarty->assign('isAdmin',$admin);
		$this->smarty->assign('product',$product);
		$this->smarty->display('showProductById.tpl');
	}
	    
    function showAdminProducts($products, $categories, $admin){
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->assign('products',$products);
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('adminProducts.tpl');
    }

    function showUpdateProduct($product, $products, $categories, $admin){
        $this->smarty->assign('isAdmin',$admin);
        $this->smarty->assign('product', $product);
        $this->smarty->assign('products', $products);
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('editProduct.tpl');
    }
}
