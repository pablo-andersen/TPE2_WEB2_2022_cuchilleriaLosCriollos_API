<?php

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '- '), '=');
}

class AuthApiHelper {

    private $key;
    function __construct(){
        $this->key="clave_secreta_123";
    }

    function getBasic (){
        $header = $this->getHeader();
        //ingresa el string "Basic base64(user:password)"
        if(strpos($header,'Basic ')=== 0){
            //Selecciona el sub-string "base64(user:password)"
            $userpass = explode(' ',$header)[1];
            //Decodifica el string
            $userpass = base64_decode($userpass);
            //Separa el string con formato user:pass en un arreglo que contiene los elementos "user" y "pass"
            $userpass = explode(':',$userpass);
            if (count($userpass)==2){
                $user = $userpass[0];
                $pass = $userpass[1];
                return array(
                    'user' => $user,
                    'pass' => $pass
                );
            }
        }
        else {
            //Si el header no es correcto, devuelve null
            return null;
        }
    }

    function createToken($user){
        $header = array(
            'typ' => 'JWT',
            'alg' => 'HS256'
        );
        $payload = array(
            'sub' => 1,
            'name' => $user['user'],
            'rol' => ['admin','other'],
            'exp' => time() + 60,
        );
        $header = json_encode($header);
        $payload = json_encode($payload);
        $header = base64url_encode($header);
        $payload = base64url_encode($payload);

        $signature = hash_hmac("SHA256", "$header.$payload",$this->key,true);
        $signature = base64url_encode($signature);
        return "$header.$payload.$signature";
    }

    function getHeader(){
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            return $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        elseif(isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return $_SERVER['HTTP_AUTHORIZATION'];
        }
        else {
            return null;
        }
    }

    function getUser(){
        $header = $this->getHeader();

        if(strpos($header,'Bearer ')===0){
            $token = explode(' ', $header)[1];
            $tokenParts = explode ('.', $token);
            if (count($tokenParts)===3){
                $header = $tokenParts[0];
                $payload = $tokenParts[1];
                $signature = $tokenParts[2];
                $newSignature = hash_hmac("SHA256", "$header.$payload",$this->key,true);
                $newSignature = base64url_encode($newSignature);
                if($signature== $newSignature){
                    $payload = base64_decode($payload);
                    $payload = json_decode($payload);
                    //if ($payload->exp < now()){
                        return $payload;
                    //}
                }
            }
        }
        return null;
    }

    function isLoggedIn (){
        $payload = $this->getBasic();
        if (isset($payload['sub'])) {
            return true;
        } 
        else {
            return false;
        }
    }
}