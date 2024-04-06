<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class yummycontroller
{
    public function index(){
        $restaurantService = new RestaurantService();
        $restaurants = $restaurantService->getRestaurants();
        include '../views/YummyView/YummyMain.php';
    }
}