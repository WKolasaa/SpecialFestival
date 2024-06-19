<?php

namespace App\Controllers;

use App\Services\HomeContentService;

class HomeController
{
    private HomeContentService $service;

    public function __construct()
    {

        $this->service = new HomeContentService();
    }

    public function index()
    {
        $service = $this->service;
        include '../views/home.php';
    }
}