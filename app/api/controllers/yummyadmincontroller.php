<?php

namespace App\Controllers;

use App\Models\Restaurant;
use App\Models\restaurantReservation;
use App\Models\restaurantSession;
use App\Services\restaurantservice;

class YummyAdminController
{
    private $restaurantService;

    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
    }

    public function getAllRestaurants()
    {
        try{
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $restaurants = $this->restaurantService->getRestaurants();
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

            $restaurant = $this->restaurantService->getRestaurantByID($restaurantID);
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

            $restaurants = $this->restaurantService->getRestaurants();

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

                $restaurant = $this->restaurantService->getRestaurantByID($restaurantID);

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

            if($this->restaurantService->updateSession($restaurantSession)){
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

            if($this->restaurantService->addRestaurant($restaurant)){
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

                $restaurant = $this->restaurantService->getRestaurantByID($restaurantID);

                $images = [];
                foreach ($restaurant->getImagesAsArray() as $image) {
                    $images[] = $image;
                }

            }

            echo json_encode($images);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function addSession(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $restaurantSession = new RestaurantSession();
            $restaurantSession->setRestaurantId(intval($jsonData['restaurant_id']));
            $restaurantSession->setEventDate($jsonData['event_date']);
            $restaurantSession->setEventDay($jsonData['event_day']);
            $restaurantSession->setEventTimeStart($jsonData['event_time_start']);
            $restaurantSession->setEventTimeEnd($jsonData['event_time_end']);
            $restaurantSession->setSeatsTotal(intval($jsonData['seats_total']));
            $restaurantSession->setSeatsLeft(intval($jsonData['seats_left']));

            if($this->restaurantService->addSession($restaurantSession)){
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

            if($this->restaurantService->updateRestaurant($restaurant)){
                echo json_encode(['success' => 'Restaurant updated']);
            }
            else{
                echo json_encode(['error' => 'Failed to update restaurant']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function deleteSession(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $sessionID = $jsonData['id'];

            if($this->restaurantService->deleteSession($sessionID)){
                echo json_encode(['success' => 'Event deleted']);
            }
            else{
                echo json_encode(['error' => 'Failed to delete event']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function updateImage() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define the directory where the image will be saved
            $uploadDir = 'img/Yummy/';

            // Generate a unique filename for the image
            $filename = uniqid('image_') . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            // Move the uploaded image to the upload directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                // Update the image path in the database
                // You'll need to modify this part based on your database structure and framework (if any)
                $fileType = $_FILES['image']['type'];
                if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif' && $fileType != 'image/jpg' && $fileType != 'image/JPG' && $fileType != 'image/PNG' && $fileType != 'image/GIF') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG, or GIF image.']);
                    return;
                }

                $fileSize = $_FILES['image']['size'];
                if ($fileSize > 10 * 1024 * 1024) {
                    http_response_code(400);
                    echo json_encode(['error' => 'File is too large. Maximum size is 10MB.']);
                    return;
                }

                $imagePath = 'img/Yummy/' . $filename; // Assuming the image path is stored in 'img' directory

                if($this->restaurantService->updateImage($_POST['id'], $imagePath)){
                    echo json_encode(['success' => 'Image updated successfully']);
                }
                else {
                    echo json_encode(['error' => 'Failed to update database with the new image path']);
                }

            } else {
                // Respond with an error message if failed to move the image
                echo json_encode(['error' => 'Failed to move the uploaded image']);
            }
        } else {
            // Respond with an error message if no image file was uploaded
            echo json_encode(['error' => 'No image file uploaded or an error occurred']);
        }
    }

    public function getAllReservations(){
        try{
            $reservation = $this->restaurantService->getAllReservations();

            $reservations = [];
            foreach ($reservation as $res) {
                $reservations[] = $res->ToArray();
            }

            echo json_encode($reservations);
        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function updateReservation(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $reservation = new RestaurantReservation();
            $reservation->setId(intval($jsonData['id']));
            $reservation->setRestaurantId(intval($jsonData['restaurantId']));
            $reservation->setEventID(intval($jsonData['eventId']));
            $reservation->setRegularTickets(intval($jsonData['regularTickets']));
            $reservation->setReducedTickets(intval($jsonData['reducedTickets']));
            $reservation->setSpecialRequests($jsonData['specialRequests']);
            $reservation->setEnabled($jsonData['enabled']);

            if($this->restaurantService->updateReservation($reservation)){
                echo json_encode(['success' => 'Reservation updated']);
            }
            else{
                echo json_encode(['error' => 'Failed to update reservation']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function deleteReservation(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $reservationID = $jsonData['reservationId'];

            if($this->restaurantService->deleteReservation($reservationID)){
                echo json_encode(['success' => 'Reservation deleted']);
            }
            else{
                echo json_encode(['error' => 'Failed to delete reservation']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    public function addReservation(){
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if($jsonData !== null){
            $reservation = new RestaurantReservation();
            $reservation->setRestaurantId(intval($jsonData['restaurantId']));
            $reservation->setEventID(intval($jsonData['eventID']));
            $reservation->setRegularTickets(intval($jsonData['regularTickets']));
            $reservation->setReducedTickets(intval($jsonData['reducedTickets']));
            $reservation->setSpecialRequests($jsonData['specialRequests']);
            $reservation->setEnabled(true);

            if($this->restaurantService->reserve($reservation)){
                echo json_encode(['success' => 'Reservation added']);
            }
            else{
                echo json_encode(['error' => 'Failed to add reservation']);
            }
        }else{
            echo json_encode(['error' => 'Invalid data']);
        }
    }
}