<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class restaurantscontroller
{
    public function index()
    {
        try{
            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getRestaurants();
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
        include __DIR__ . '/../views/YummyView/restaurants.php';
    }
}