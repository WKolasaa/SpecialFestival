<?php

namespace App\Controllers;


class LoginController{

    private $loginService;

    public function __construct()
    {
      //  $this->loginService = new LoginService();
    }

    public function index(){
        include '../views/login.php';

    }

}