<?php 

namespace App\Repositories;

use App\Models\restaurant;
use App\Models\RestaurantImage;
use App\Models\RestaurantReservation;
use App\Models\RestaurantSession;
use PDO;

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
            $sql = "SELECT id, restaurant_id, image_path, image_type FROM restaurant_images WHERE restaurant_id = ?";
            $imageStmt = $this->connection->prepare($sql);
            $imageStmt->execute([$restaurant->getId()]);
            $imageRows = $imageStmt->fetchAll();

            foreach ($imageRows as $imageRow) {
                $image = new RestaurantImage();
                $image->setId($imageRow['id']);
                $image->setRestaurantId($restaurant->getId());
                $image->setImagePath($imageRow['image_path']);
                $image->setImageType($imageRow['image_type']);

                $restaurant->addImage($image);
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

    public function deleteSession($sessionID){
        $sql = "DELETE FROM restaurant_events WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute($sessionID);

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
    // TODO: Make method to update images
    public function updateImages($id, $imagePath)
    {
        $sql = "UPDATE restaurant_images SET image_path = :image_path WHERE id = :image_id";
        $updateStmt = $this->connection->prepare($sql);

        $updateStmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
        $updateStmt->bindParam(':image_id', $id, PDO::PARAM_STR);

        if($updateStmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getEventByID($id){
        $sql = "SELECT id, restaurant_id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        $rows = $statement->fetchAll();

        if (empty($rows)) {
            return null; // No event found with the provided ID
        }

        $events = [];
        foreach ($rows as $row) {
            $event = new RestaurantSession();
            $event->setId($row['id']);
            $event->setRestaurantId($row['restaurant_id']);
            $event->setEventDate($row['event_date']);
            $event->setEventDay($row['event_day']);
            $event->setEventTimeStart($row['event_time_start']);
            $event->setEventTimeEnd($row['event_time_end']);
            $event->setSeatsTotal($row['seats_total']);
            $event->setSeatsLeft($row['seats_left']);

            array_push($events, $event);
        }

        return $events[0];
    }

    public function reserve($reservation){
        // Get the event and calculate the remaining seats
        $event = $this->getEventByID($reservation->getEventID());
        if ($event === null) {
            // Handle the case where the event is not found
            error_log('Event not found.');
            return false;
        }
        $seatsLeft = $event->getSeatsLeft();
        $seatsLeft -= $reservation->getRegularTickets() + $reservation->getReducedTickets();

        if ($seatsLeft < 0) {
            // Handle the case where there are not enough seats left
            error_log('Not enough seats left.');
            return false;
        }

        // Insert the reservation into the database
        $sql = "INSERT INTO restaurant_reservations (restaurantId, eventID, regularTickets, reducedTickets, specialRequests) VALUES (:restaurantID, :eventID, :regularTickets, :reducedTickets, :specialRequests)";
        $statement = $this->connection->prepare($sql);
        $successInsert = $statement->execute([
            ':restaurantID' => $reservation->getRestaurantId(),
            ':eventID' => $reservation->getEventID(),
            ':regularTickets' => $reservation->getRegularTickets(),
            ':reducedTickets' => $reservation->getReducedTickets(),
            ':specialRequests' => $reservation->getSpecialRequests()
        ]);

        if (!$successInsert) {
            // Handle the case where insertion fails
            error_log('Reservation insertion failed.');
            return false;
        }

        // Update the number of seats left for the event
        $sql = "UPDATE restaurant_events SET seats_left = :seats_left WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $successUpdate = $statement->execute([
            ':seats_left' => $seatsLeft,
            ':id' => $reservation->getEventID()
        ]);

        if (!$successUpdate) {
            // Handle the case where updating seats left fails
            // You may want to consider rolling back the reservation insertion here
            error_log('Updating seats left failed.');
            return false;
        }

        return true;
    }

    public function getAllReservations(){
        $sql = "SELECT id, restaurantId, eventID, regularTickets, reducedTickets, specialRequests, enabled FROM restaurant_reservations";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        $reservations = [];
        foreach ($rows as $row) {
            $reservation = new RestaurantReservation();
            $reservation->setId($row['id']);
            $reservation->setRestaurantId($row['restaurantId']);
            $reservation->setEventID($row['eventID']);
            $reservation->setRegularTickets($row['regularTickets']);
            $reservation->setReducedTickets($row['reducedTickets']);
            $reservation->setSpecialRequests($row['specialRequests']);
            if($row['enabled'] == 1){
                $reservation->setEnabled(true);
            } else {
                $reservation->setEnabled(false);
            }
            // Check if the event exists
            $event = $this->getEventByID($row['eventID']);
            if ($event !== null) {
                $reservation->setDate($event->getEventDate());
                $reservation->setStartTime($event->getEventTimeStart());
                $reservation->setEndTime($event->getEventTimeEnd());
            } else {
                error_log('Event not found.');
                continue;
            }

            array_push($reservations, $reservation);
        }

        return $reservations;
    }

    public function updateReservation($reservation){
        $sql = "UPDATE restaurant_reservations SET restaurantId = :restaurantId, eventID = :eventID, regularTickets = :regularTickets, reducedTickets = :reducedTickets, specialRequests = :specialRequests, enabled = :enabled WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        if($reservation->getEnabled()){
            $enabled = 1;
        } else {
            $enabled = 0;
        }
        return $statement->execute([
            ':restaurantId' => $reservation->getRestaurantId(),
            ':eventID' => $reservation->getEventID(),
            ':regularTickets' => $reservation->getRegularTickets(),
            ':reducedTickets' => $reservation->getReducedTickets(),
            ':specialRequests' => $reservation->getSpecialRequests(),
            ':enabled' => $enabled,
            ':id' => $reservation->getId()
        ]);

    }

    public function deleteReservation($reservationID){
        $sql = "DELETE FROM restaurant_reservations WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([$reservationID]);
    }

}