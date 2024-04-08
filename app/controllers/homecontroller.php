<?php

namespace App\Controllers;
use App\Services\HomeContentService;

class HomeController{
  private $service;

    public function __construct(){
      
      $this->service=new HomeContentService();
    }

    public function index()
    {
      $service = $this->getHomeContentService();
      include '../views/home.php';
    }
    
    private function getHomeContentService() 
    {
      return $this->service;
    }
}