<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class YummyAdminController
{
    public function getAllRestaurants()
    {
        try{
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getAllRestaurants();
            var_dump($restaurants);
            echo json_encode($restaurants);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}