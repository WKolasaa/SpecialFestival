<?php

namespace App\Controllers;

use App\Services\RestaurantService;

class yummyController
{
    public function index()
    {
        $restaurantService = new RestaurantService();
        $restaurants = $restaurantService->getRestaurants();
        include '../views/YummyView/YummyMain.php';
    }
}