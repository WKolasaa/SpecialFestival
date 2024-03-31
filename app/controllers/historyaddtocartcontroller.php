<?php

namespace App\Controllers;
use App\Services\UserService;

class HistoryAddToCartController{
private $userService;
    public function __construct(){

    $this->userService=new UserService();

    }

    public function index()
    {
      include '../views/HistoryView/HistoryAddToCart.php';
      
    }
    
    
}