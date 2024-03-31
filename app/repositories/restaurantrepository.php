<?php 

namespace App\Repositories;

use App\Models\restaurant;

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
            $sql = "SELECT event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE restaurant_id = ?";
            $eventStmt = $this->connection->prepare($sql);
            $eventStmt->execute([$restaurant->getId()]);
            $eventRows = $eventStmt->fetchAll();

            $events = [];
            foreach ($eventRows as $eventRow) {
                $restaurant->addEvent($eventRow['event_date'], $eventRow['event_day'], $eventRow['event_time_start'], $eventRow['event_time_end'], $eventRow['seats_total'], $eventRow['seats_left']);
            }
        }

        return $restaurants;
    }
}