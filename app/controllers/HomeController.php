<?php

namespace App\Controllers;

class HomeController{
    public function __construct(){

    }

    public function index()
    {
      include '../views/home.php';
      
    }
    
    
}