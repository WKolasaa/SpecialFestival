<?php 

namespace App\Repositories;

use App\Models\restaurant;
use App\Models\restaurantSession;

class RestaurantRepository extends Repository
{
    public function getRestaurants(){
        $sql = "SELECT id, name, address, type, price, reduced, stars, phoneNumber, email, website, chef FROM restaurants";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        $restaurants = $this->mapToRestaurants($rows);

        $restaurants = $this->setImages($restaurants);

        $restaurants = $this->setEvents($restaurants);

        return $restaurants;
    }

    public function getRestaurantByID($restaurantID){
        $sql = "SELECT id, name, address, type, price, reduced, stars, phoneNumber, email, website, chef FROM restaurants WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$restaurantID]);
        $rows = $statement->fetchAll();

        $restaurants = $this->mapToRestaurants($rows);

        $restaurants = $this->setImages($restaurants);

        $restaurants = $this->setEvents($restaurants);

        $restaurant = new Restaurant();
        $restaurant = $restaurants[0];

        return $restaurant;
    }

    private function mapToRestaurants($rows){
        $restaurants = [];
        foreach ($rows as $row) {
            $restaurant = new Restaurant();
            $restaurant->setId($row['id']);
            $restaurant->setName($row['name']);
            $restaurant->setAddress($row['address']);
            $restaurant->setType($row['type']);
            $restaurant->setPrice($row['price']);
            $restaurant->setReduced($row['reduced']);
            $restaurant->setStars($row['stars']);
            $restaurant->setPhoneNumber($row['phoneNumber']);
            $restaurant->setEmail($row['email']);
            $restaurant->setWebsite($row['website']);
            $restaurant->setChef($row['chef']);

            array_push($restaurants, $restaurant);
        }

        return $restaurants;
    }

    private function setImages($restaurants)
    {
        foreach ($restaurants as $restaurant) {
            $sql = "SELECT image_path, image_type FROM restaurant_images WHERE restaurant_id = ?";
            $imageStmt = $this->connection->prepare($sql);
            $imageStmt->execute([$restaurant->getId()]);
            $imageRows = $imageStmt->fetchAll();

            foreach ($imageRows as $imageRow) {
                $restaurant->setImagePath($imageRow['image_type'], $imageRow['image_path']);
            }
        }

        return $restaurants;
    }

    private function setEvents($restaurants){
        foreach ($restaurants as $restaurant) {
            $sql = "SELECT id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE restaurant_id = ?";
            $eventStmt = $this->connection->prepare($sql);
            $eventStmt->execute([$restaurant->getId()]);
            $eventRows = $eventStmt->fetchAll();

            $events = [];
            foreach ($eventRows as $eventRow) {
                $event = new RestaurantSession();
                $event->setId($eventRow['id']);
                $event->setRestaurantId($restaurant->getId());
                $event->setEventDate($eventRow['event_date']);
                $event->setEventDay($eventRow['event_day']);
                $event->setEventTimeStart($eventRow['event_time_start']);
                $event->setEventTimeEnd($eventRow['event_time_end']);
                $event->setSeatsTotal($eventRow['seats_total']);
                $event->setSeatsLeft($eventRow['seats_left']);

                $restaurant->addEvent($event);
            }
        }

        return $restaurants;
    }

    public function addRestaurant($restaurant){
        $sql = "INSERT INTO restaurants (name, address, type, price, reduced, stars, phoneNumber, email, website, chef) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute([$restaurant->getName(), $restaurant->getAddress(), $restaurant->getType(), $restaurant->getPrice(), $restaurant->getReduced(), $restaurant->getStars(), $restaurant->getPhoneNumber(), $restaurant->getEmail(), $restaurant->getWebsite(), $restaurant->getChef()]);

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function updateSession($session){ //TODO: Potential SQL Injection
        $sql = "UPDATE restaurant_events SET restaurant_id = ?, event_date = ?, event_day = ?, event_time_start = ?, event_time_end = ?, seats_total = ?, seats_left = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute([$session->getRestaurantId() ,$session->getEventDate(), $session->getEventDay(), $session->getEventTimeStart(), $session->getEventTimeEnd(), $session->getSeatsTotal(), $session->getSeatsLeft(), $session->getId()]);

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function addSession($restaurantSession){
        $sql = "INSERT INTO restaurant_events (restaurant_id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute([$restaurantSession->getRestaurantId(), $restaurantSession->getEventDate(), $restaurantSession->getEventDay(), $restaurantSession->getEventTimeStart(), $restaurantSession->getEventTimeEnd(), $restaurantSession->getSeatsTotal(), $restaurantSession->getSeatsLeft()]);

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function updateRestaurant($restaurant){
        $sql = "UPDATE restaurants SET name = ?, address = ?, type = ?, price = ?, reduced = ?, stars = ?, phoneNumber = ?, email = ?, website = ?, chef = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute([$restaurant->getName(), $restaurant->getAddress(), $restaurant->getType(), $restaurant->getPrice(), $restaurant->getReduced(), $restaurant->getStars(), $restaurant->getPhoneNumber(), $restaurant->getEmail(), $restaurant->getWebsite(), $restaurant->getChef(), $restaurant->getId()]);

        if($success){
            return true;
        } else {
            return false;
        }
    }
}