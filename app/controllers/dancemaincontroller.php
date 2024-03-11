<?php

namespace App\Controllers;
use App\Services\UserService;

class DanceMainController{
private $userService;
    public function __construct(){

    $this->userService=new UserService();

    }

    public function index()
    {
      include '../views/DanceView/DanceMain.php';
      
    }
    
    
}