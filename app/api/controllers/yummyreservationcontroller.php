<?php

namespace App\Controllers;

use App\Services\restaurantservice;

class yummyreservationcontroller
{
    private $restaurantService;

    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
    }

    public function getRestaurantEvents(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);
        if($jsonData !== null){
            $restaurantID = intval($jsonData['restaurantID']);
            $restaurant =  $this->restaurantService->getRestaurantByID($restaurantID);
        }

        //var_dump($restaurant->getEvents());
        echo json_encode($restaurant->getEvents());
        return $restaurant->getEvents();
    }
}