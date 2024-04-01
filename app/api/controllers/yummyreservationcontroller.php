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
        if($jsonData !== null && isset($jsonData['restaurantID'])){
            $restaurantID = intval($jsonData['restaurantID']);
            $restaurant =  $this->restaurantService->getRestaurantByID($restaurantID);

            // Check if the restaurant object is not null before accessing its events
            if($restaurant !== null) {
                //var_dump($restaurant->getEvents());
                $eventArray = [];
                foreach ($restaurant->getEventsAsArray() as $event) {
                    $eventArray[] = $event;
                }
                echo json_encode($eventArray);
                //echo json_encode($restaurant->getEventsAsArray());
                return $restaurant->getEvents();
            } else {
                // Handle case when restaurant is not found
                echo json_encode(array('error' => 'Restaurant not found'));
                return null;
            }
        } else {
            // Handle case when restaurantID is not provided or JSON data is invalid
            echo json_encode(array('error' => 'Invalid restaurantID'));
            return null;
        }
    }

}