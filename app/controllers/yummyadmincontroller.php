<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class YummyAdminController
{
    public function index()
    {
        try{
            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getRestaurants();
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
        }
        include '../views/adminViews/yummyEventadmin.php';
    }

    public function addrestaurant()
    {
        include '../views/adminViews/yummy/addRestaurant.php';
    }
}