<?php 

namespace App\Repositories;

use App\Models\restaurant;
use App\Models\restaurantImage;
use App\Models\restaurantReservation;
use App\Models\restaurantSession;
use App\Services\TicketService;
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
            $sql = "SELECT id, restaurant_id, image_path, image_type FROM restaurant_images WHERE restaurant_id = :restaurant_id";
            $imageStmt = $this->connection->prepare($sql);
            $restaurantID = $restaurant->getId();
            $imageStmt->bindParam(':restaurant_id',$restaurantID,PDO::PARAM_INT);
            $imageStmt->execute();
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
            $sql = "SELECT id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE restaurant_id = :restaurant_id";
            $eventStmt = $this->connection->prepare($sql);
            $restaurantID = $restaurant->getId();
            $eventStmt->bindParam(":restaurant_id",$restaurantID,PDO::PARAM_INT);
            $eventStmt->execute();
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
        $sql = "INSERT INTO restaurants (name, address, type, price, reduced, stars, phoneNumber, email, website, chef) VALUES (:name, :address, :type, :price, :reduced, :stars, :phoneNumber, :email, :website, :chef)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':name', $restaurant->getName(), PDO::PARAM_STR);
        $statement->bindParam(':address', $restaurant->getAddress(), PDO::PARAM_STR);
        $statement->bindParam(':type', $restaurant->getType(), PDO::PARAM_STR);
        $statement->bindParam(':price', $restaurant->getPrice(), PDO::PARAM_INT);
        $statement->bindParam(':reduced', $restaurant->getReduced(), PDO::PARAM_INT);
        $statement->bindParam(':stars', $restaurant->getStars(), PDO::PARAM_INT);
        $statement->bindParam(':phoneNumber', $restaurant->getPhoneNumber(), PDO::PARAM_STR);
        $statement->bindParam(':email', $restaurant->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':website', $restaurant->getWebsite(), PDO::PARAM_STR);
        $statement->bindParam(':chef', $restaurant->getChef(), PDO::PARAM_STR);
        $success = $statement->execute();

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function updateSession($session){ //TODO: Potential SQL Injection
        $sql = "UPDATE restaurant_events SET restaurant_id = :restaurantId, event_date = :eventDate, event_day = :eventDay, event_time_start = :eventTimeStart, event_time_end = :eventTimeEnd, seats_total = :seatsTotal, seats_left = :seatsLeft WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':restaurantId', $session->getRestaurantId(), PDO::PARAM_INT);
        $statement->bindParam(':eventDate', $session->getEventDate(), PDO::PARAM_STR);
        $statement->bindParam(':eventDay', $session->getEventDay(), PDO::PARAM_STR);
        $statement->bindParam(':eventTimeStart', $session->getEventTimeStart(), PDO::PARAM_STR);
        $statement->bindParam(':eventTimeEnd', $session->getEventTimeEnd(), PDO::PARAM_STR);
        $statement->bindParam(':seatsTotal', $session->getSeatsTotal(), PDO::PARAM_INT);
        $statement->bindParam(':seatsLeft', $session->getSeatsLeft(), PDO::PARAM_INT);
        $statement->bindParam(':id', $session->getId(), PDO::PARAM_INT);
        $success = $statement->execute();

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function addSession($restaurantSession){
        $sql = "INSERT INTO restaurant_events (restaurant_id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left) VALUES (:restaurantId, :eventDate, :eventDay, :eventTimeStart, :eventTimeEnd, :seatsTotal, :seatsLeft)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':restaurantId', $restaurantSession->getRestaurantId(), PDO::PARAM_INT);
        $statement->bindParam(':eventDate', $restaurantSession->getEventDate(), PDO::PARAM_STR);
        $statement->bindParam(':eventDay', $restaurantSession->getEventDay(), PDO::PARAM_STR);
        $statement->bindParam(':eventTimeStart', $restaurantSession->getEventTimeStart(), PDO::PARAM_STR);
        $statement->bindParam(':eventTimeEnd', $restaurantSession->getEventTimeEnd(), PDO::PARAM_STR);
        $statement->bindParam(':seatsTotal', $restaurantSession->getSeatsTotal(), PDO::PARAM_INT);
        $statement->bindParam(':seatsLeft', $restaurantSession->getSeatsLeft(), PDO::PARAM_INT);
        $success = $statement->execute();

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function deleteSession($sessionID){
        $sql = "DELETE FROM restaurant_events WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $sessionID, PDO::PARAM_INT);
        $success = $statement->execute();

        if($success){
            return true;
        } else {
            return false;
        }
    }

    public function updateRestaurant($restaurant){
        $sql = "UPDATE restaurants SET name = :name, address = :address, type = :type, price = :price, reduced = :reduced, stars = :stars, phoneNumber = :phoneNumber, email = :email, website = :website, chef = :chef WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':name', $restaurant->getName(), PDO::PARAM_STR);
        $statement->bindParam(':address', $restaurant->getAddress(), PDO::PARAM_STR);
        $statement->bindParam(':type', $restaurant->getType(), PDO::PARAM_STR);
        $statement->bindParam(':price', $restaurant->getPrice(), PDO::PARAM_INT);
        $statement->bindParam(':reduced', $restaurant->getReduced(), PDO::PARAM_INT);
        $statement->bindParam(':stars', $restaurant->getStars(), PDO::PARAM_INT);
        $statement->bindParam(':phoneNumber', $restaurant->getPhoneNumber(), PDO::PARAM_STR);
        $statement->bindParam(':email', $restaurant->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':website', $restaurant->getWebsite(), PDO::PARAM_STR);
        $statement->bindParam(':chef', $restaurant->getChef(), PDO::PARAM_STR);
        $statement->bindParam(':id', $restaurant->getId(), PDO::PARAM_INT);
        $success = $statement->execute();

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
        $sql = "SELECT id, restaurant_id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
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

        $restaurantID = $reservation->getRestaurantId();
        $eventID = $reservation->getEventID();
        $regularTickets = $reservation->getRegularTickets();
        $reducedTickets = $reservation->getReducedTickets();
        $specialRequests = $reservation->getSpecialRequests();

        $statement->bindParam(':restaurantID', $restaurantID);
        $statement->bindParam(':eventID', $eventID);
        $statement->bindParam(':regularTickets', $regularTickets);
        $statement->bindParam(':reducedTickets', $reducedTickets);
        $statement->bindParam(':specialRequests', $specialRequests);
        $successInsert = $statement->execute();

        if (!$successInsert) {
            // Handle the case where insertion fails
            error_log('Reservation insertion failed.');
            return false;
        }

        // Update the number of seats left for the event
        $sql = "UPDATE restaurant_events SET seats_left = :seats_left WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':seats_left', $seatsLeft);
        $statement->bindParam(':id', $eventID);
        $successUpdate = $statement->execute();

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

        $restaurantID = $reservation->getRestaurantId();
        $eventID = $reservation->getEventID();
        $regularTickets = $reservation->getRegularTickets();
        $reducedTickets = $reservation->getReducedTickets();
        $specialRequests = $reservation->getSpecialRequests();
        $id = $reservation->getId();

        $statement->bindParam(':restaurantId', $restaurantID);
        $statement->bindParam(':eventID', $eventID);
        $statement->bindParam(':regularTickets', $regularTickets);
        $statement->bindParam(':reducedTickets', $reducedTickets);
        $statement->bindParam(':specialRequests', $specialRequests);
        $statement->bindParam(':enabled', $enabled);
        $statement->bindParam(':id', $id);

        return $statement->execute();

    }

    public function deleteReservation($reservationID){
        $sql = "DELETE FROM restaurant_reservations WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':id', $reservationID);

        return $statement->execute();
    }
}