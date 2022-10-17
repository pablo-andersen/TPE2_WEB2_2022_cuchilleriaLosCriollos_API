<?php

require_once 'app/views/homeView.php';
require_once 'app/helpers/AuthHelper.php';

class HomeController{

    private $homeView;
    private $authHelper;

    function __construct(){
        $this->homeView = new HomeView();
        $this->authHelper = new AuthHelper();     
    }

    function showHome(){
        $admin = $this->authHelper->checkLoggedIn();
        $this->homeView->showHome($admin);
    }
}