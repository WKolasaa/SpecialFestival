<?php

namespace App\Controllers;


use App\Services\UserService;

class LoginController{

    private $userService;

    public function __construct()
    {
        //$this->$userService = new UserService();
    }

    public function index(){
        include '../views/login.php';

    }

    public function login(){
        $loginInput = $_POST['username'];
        $password = $_POST['password'];
        $userService = new UserService();
        if(filter_var($loginInput, FILTER_VALIDATE_EMAIL)){
            $user = $userService->loginByEmail($loginInput, $password);
        }else{
            $user = $userService->loginByUserName($loginInput, $password);
        }

        if($user){
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['userClass'] = null; // TODO: Get user class from database
            header('Location: /');
        }else{
            echo "Wrong username or password";
        }
    }
}