<?php

require_once 'app/models/userModel.php';
require_once 'app/views/api-view.php';
require_once 'app/helpers/AuthApiHelper.php';

class UserApiController {
    private $userModel;
    private $view;
    private $authApiHelper;

    function __construct(){
        $this->userModel = new UserModel();
        $this->view = new ApiView();
        $this->authApiHelper = new AuthApiHelper();
    }

    function getToken($params=null){
        $userpass = $this->authApiHelper->getBasic();

        //Se obtiene el user de la DB
        //$user = $this->userModel->getUser($email);
        $user = array('user' => $userpass['user']);

        //Se verifica que el usuario existe en DB y la contaseña coincide
        if(true/*$user && password_verify($password, $user->password)*/){
            $token = $this->authApiHelper->createToken($user);

            //Devuelve un token
            $this->view->response(["token"=>$token],200);
        }
        else {
            $this->view->response('Usuario y/o contraseñas no válidos', 401);
        }
    }

    function getUser($params=null){
        if($params){
            $id = $params[':ID'];
            $user = $this->authApiHelper->getUser();
            if($user) {
                if($id == $user->sub){
                    $this->view->response($user, 200);
                }
                else {
                    $this->view->response('Forbidden', 403);
                }
            }
            else {
                $this->view->response('Unauthorized', 401);    
            }
        }
    }
}