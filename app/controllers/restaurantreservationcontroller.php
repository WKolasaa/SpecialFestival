<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class restaurantreservationcontroller
{
    public function index()
    {
        if(isset($_GET['restaurantId'])){
            $restaurantId = (int) $_GET['restaurantId'];
            try{
                $restaurantService = new RestaurantService();
                $restaurant = $restaurantService->getRestaurantByID($restaurantId);
                $_SESSION['restaurant'] = $restaurant;
                include __DIR__ . '/../views/YummyView/reservation.php';
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo "Error";
        }
    }
}