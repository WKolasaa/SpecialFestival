<?php 

namespace App\Repositories;

use App\Models\restaurant;

class RestaurantRepository extends Repository
{
    public function getRestaurants(){
        $sql = "SELECT id, name, address, type, price, reduced, firstSession, duration, sessions, stars, phoneNumber, email, website, chef, seats FROM restaurants";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        $restaurants = $this->mapToRestaurants($rows);

        $restaurants = $this->setImages($restaurants);

        return $restaurants;
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
            $restaurant->setFirstSession($row['firstSession']);
            $restaurant->setDuration($row['duration']);
            $restaurant->setSessions($row['sessions']);
            $restaurant->setStars($row['stars']);
            $restaurant->setPhoneNumber($row['phoneNumber']);
            $restaurant->setEmail($row['email']);
            $restaurant->setWebsite($row['website']);
            $restaurant->setChef($row['chef']);
            $restaurant->setSeats($row['seats']);

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

            $events = []; // Initialize an empty array to hold the event data
            foreach ($eventRows as $eventRow) {
                // Format the event date as a key for grouping events by date
                $eventDate = $eventRow['event_date'];

                // Create an associative array for each session
                $session = [
                    'event_time_start' => $eventRow['event_time_start'],
                    'event_time_end' => $eventRow['event_time_end'],
                    'seats_total' => $eventRow['seats_total'],
                    'seats_left' => $eventRow['seats_left']
                ];

                // Group sessions by event date
                if (!isset($events[$eventDate])) {
                    $events[$eventDate] = [
                        'event_day' => $eventRow['event_day'],
                        'sessions' => []
                    ];
                }

                // Append the session to the sessions array for the corresponding date
                $events[$eventDate]['sessions'][] = $session;
            }

            // Add the events array to the restaurant object
            if (!empty($events)) {
                foreach ($events as $eventDate => $eventData) {
                    $restaurant->addEvent($eventDate, $eventData['event_day'], $eventData['sessions']);
                }
            }
        }

        return $restaurants;
    }
}