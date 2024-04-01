<?php

namespace App\Controllers;

use App\Models\Restaurant;
use App\Models\restaurantSession;
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
            $restaurants = $restaurantService->getRestaurants();
            echo json_encode($restaurants);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getRestaurantById(){
        try{
            $jsonData = file_get_contents('php://input');
            $jsonData = json_decode($jsonData, true);
            $restaurantID = intval($jsonData['restaurantId']);

            $restaurantService = new RestaurantService();
            $restaurant = $restaurantService->getRestaurantByID($restaurantID);
            echo json_encode($restaurant);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getAllRestaurantsEvents(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getRestaurants();

            $eventArray = [];
            foreach ($restaurants as $restaurant) {
                foreach ($restaurant->getEventsAsArray() as $event) {
                    $eventArray[] = $event;
                }
            }


            echo json_encode($eventArray);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function getRestaurantsEventsById(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $jsonData = file_get_contents('php://input');
            $jsonData = json_decode($jsonData, true);
            if($jsonData !== null){
                $restaurantID = intval($jsonData['restaurantId']);
                $restaurantService = new RestaurantService();
                $restaurant = $restaurantService->getRestaurantByID($restaurantID);

                $eventArray = [];
                foreach ($restaurant->getEventsAsArray() as $event) {
                    $eventArray[] = $event;
                }
            }

            echo json_encode($eventArray);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function updateEvent(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $restaurantSession = new RestaurantSession();
            $restaurantSession->setRestaurantId(intval($jsonData['restaurant_id']));
            $restaurantSession->setId(intval($jsonData['id']));
            $restaurantSession->setEventDate($jsonData['event_date']);
            $restaurantSession->setEventDay($jsonData['event_day']);
            $restaurantSession->setEventTimeStart($jsonData['event_time_start']);
            $restaurantSession->setEventTimeEnd($jsonData['event_time_end']);
            $restaurantSession->setSeatsTotal(intval($jsonData['seats_total']));
            $restaurantSession->setSeatsLeft(intval($jsonData['seats_left']));

            $restaurantService = new RestaurantService();
            if($restaurantService->updateSession($restaurantSession)){
                echo json_encode(['success' => 'Event updated']);
            }
            }else{
                echo json_encode(['error' => 'Invalid data']);
            }
    }

    public function addRestaurant(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $restaurant = new Restaurant();
            $restaurant->setName($jsonData['name']);
            $restaurant->setAddress($jsonData['address']);
            $restaurant->setType($jsonData['type']);
            $restaurant->setPrice($jsonData['price']);
            $restaurant->setReduced($jsonData['reduced']);
            $restaurant->setStars($jsonData['stars']);
            $restaurant->setPhone($jsonData['phone']);
            $restaurant->setEmail($jsonData['email']);
            $restaurant->setWebsite($jsonData['website']);
            $restaurant->setCity($jsonData['chef']);

            $restaurantService = new RestaurantService();
            if($restaurantService->addRestaurant($restaurant)){
                echo json_encode(['success' => 'Restaurant added']);
            }
            else{
                echo json_encode(['error' => 'Failed to add restaurant']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function getAllImagesByRestaurantId(){
        try{
            $jsonData = file_get_contents('php://input');
            $jsonData = json_decode($jsonData, true);
            if($jsonData !== null){
                $restaurantID = intval($jsonData['restaurantId']);
                $restaurantService = new RestaurantService();
                $restaurant = $restaurantService->getRestaurantByID($restaurantID);

                $images = $restaurant->getImages();
            }

            echo json_encode($images);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function addSession(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);
        echo "works";
        if($jsonData !== null){
            $restaurantSession = new RestaurantSession();
            $restaurantSession->setRestaurantId(intval($jsonData['restaurant_id']));
            $restaurantSession->setEventDate($jsonData['event_date']);
            $restaurantSession->setEventDay($jsonData['event_day']);
            $restaurantSession->setEventTimeStart($jsonData['event_time_start']);
            $restaurantSession->setEventTimeEnd($jsonData['event_time_end']);
            $restaurantSession->setSeatsTotal(intval($jsonData['seats_total']));
            $restaurantSession->setSeatsLeft(intval($jsonData['seats_left']));

            echo "object created";

            $restaurantService = new RestaurantService();
            if($restaurantService->addSession($restaurantSession)){
                echo "added";
                echo json_encode(['success' => 'Event added']);
            }
            else{
                echo "failed";
                echo json_encode(['error' => 'Failed to add event']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function updateRestaurant(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $restaurant = new Restaurant();
            $restaurant->setId(intval($jsonData['id']));
            $restaurant->setName($jsonData['name']);
            $restaurant->setAddress($jsonData['address']);
            $restaurant->setType($jsonData['type']);
            $restaurant->setPrice($jsonData['price']);
            $restaurant->setReduced($jsonData['reduced']);
            $restaurant->setStars($jsonData['stars']);
            $restaurant->setPhoneNumber($jsonData['phoneNumber']);
            $restaurant->setEmail($jsonData['email']);
            $restaurant->setWebsite($jsonData['website']);
            $restaurant->setChef($jsonData['chef']);

            $restaurantService = new RestaurantService();
            if($restaurantService->updateRestaurant($restaurant)){
                echo json_encode(['success' => 'Restaurant updated']);
            }
            else{
                echo json_encode(['error' => 'Failed to update restaurant']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }
}