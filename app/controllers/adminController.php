<?php

require_once 'app/models/adminModel.php';
require_once 'app/views/adminView.php';


class AdminController{

    private $adminView;

    function __construct(){
        $this->adminModel = new AdminModel();
        $this->adminView = new AdminView();      
    }


    function showAdminConsole(){
        $this->adminView->showConsole();
    }















}
