<?php

namespace App\Controllers;
use App\Services\UserService;

class HomeController{
private $userService;
    public function __construct(){

    $this->userService=new UserService();

    }

    public function index()
    {
      include '../views/home.php';

      
    }
    
}