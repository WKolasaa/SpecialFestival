<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\RestaurantReservation;
use App\Models\RestaurantSession;
use DateTime;
use PDO;

class RestaurantRepository extends Repository
{
    public function getRestaurants()
    {
        $sql = "SELECT id, name, address, type, price, reduced, stars, phoneNumber, email, website, chef FROM restaurants";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        $restaurants = $this->mapToRestaurants($rows);

        $restaurants = $this->setImages($restaurants);

        $restaurants = $this->setEvents($restaurants);

        return $restaurants;
    }

    private function mapToRestaurants($rows)
    {
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
            $imageStmt->bindParam(':restaurant_id', $restaurantID, PDO::PARAM_INT);
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

    private function setEvents($restaurants)
    {
        foreach ($restaurants as $restaurant) {
            $sql = "SELECT id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left FROM restaurant_events WHERE restaurant_id = :restaurant_id";
            $eventStmt = $this->connection->prepare($sql);
            $restaurantID = $restaurant->getId();
            $eventStmt->bindParam(":restaurant_id", $restaurantID, PDO::PARAM_INT);
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

    public function getRestaurantByID($restaurantID)
    {
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

    public function addRestaurant($restaurant)
    {
        $sql = "INSERT INTO restaurants (name, address, type, price, reduced, stars, phoneNumber, email, website, chef) VALUES (:name, :address, :type, :price, :reduced, :stars, :phoneNumber, :email, :website, :chef)";

        $restaurantName = $restaurant->getName();
        $restaurantAddress = $restaurant->getAddress();
        $restaurantType = $restaurant->getType();
        $restaurantPrice = $restaurant->getPrice();
        $restaurantReduced = $restaurant->getReduced();
        $restaurantStars = $restaurant->getStars();
        $restaurantPhoneNumber = $restaurant->getPhoneNumber();
        $restaurantEmail = $restaurant->getEmail();
        $restaurantWebsite = $restaurant->getWebsite();
        $restaurantChef = $restaurant->getChef();

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':name', $restaurantName, PDO::PARAM_STR);
        $statement->bindParam(':address', $restaurantAddress, PDO::PARAM_STR);
        $statement->bindParam(':type', $restaurantType, PDO::PARAM_STR);
        $statement->bindParam(':price', $restaurantPrice, PDO::PARAM_INT);
        $statement->bindParam(':reduced', $restaurantReduced, PDO::PARAM_INT);
        $statement->bindParam(':stars', $restaurantStars, PDO::PARAM_INT);
        $statement->bindParam(':phoneNumber', $restaurantPhoneNumber, PDO::PARAM_STR);
        $statement->bindParam(':email', $restaurantEmail, PDO::PARAM_STR);
        $statement->bindParam(':website', $restaurantWebsite, PDO::PARAM_STR);
        $statement->bindParam(':chef', $restaurantChef, PDO::PARAM_STR);
        $success = $statement->execute();

        return $success;
    }

    public function updateSession($session)
    {
        $sql = "UPDATE restaurant_events SET restaurant_id = :restaurantId, event_date = :eventDate, event_day = :eventDay, event_time_start = :eventTimeStart, event_time_end = :eventTimeEnd, seats_total = :seatsTotal, seats_left = :seatsLeft WHERE id = :id";
        //var_dump($session);
        $restaurantId = $session->getRestaurantId();
        $eventDate = $session->getEventDate();
        $eventDay = $session->getEventDay();
        $eventTimeStart = $session->getEventTimeStart();
        $eventTimeEnd = $session->getEventTimeEnd();
        $seatsTotal = $session->getSeatsTotal();
        $seatsLeft = $session->getSeatsLeft();
        $id = $session->getId();

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $statement->bindParam(':eventDay', $eventDay, PDO::PARAM_STR);
        $statement->bindParam(':eventTimeStart', $eventTimeStart, PDO::PARAM_STR);
        $statement->bindParam(':eventTimeEnd', $eventTimeEnd, PDO::PARAM_STR);
        $statement->bindParam(':seatsTotal', $seatsTotal, PDO::PARAM_INT);
        $statement->bindParam(':seatsLeft', $seatsLeft, PDO::PARAM_INT);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $statement->execute();

        return $success;
    }

    public function addSession($restaurantSession)
    {
        $sql = "INSERT INTO restaurant_events (restaurant_id, event_date, event_day, event_time_start, event_time_end, seats_total, seats_left) VALUES (:restaurantId, :eventDate, :eventDay, :eventTimeStart, :eventTimeEnd, :seatsTotal, :seatsLeft)";

        $restaurantId = $restaurantSession->getRestaurantId();
        $eventDate = $restaurantSession->getEventDate();
        $eventDay = $restaurantSession->getEventDay();
        $eventTimeStart = $restaurantSession->getEventTimeStart();
        $eventTimeEnd = $restaurantSession->getEventTimeEnd();
        $seatsTotal = $restaurantSession->getSeatsTotal();
        $seatsLeft = $restaurantSession->getSeatsLeft();

        $dateTime = DateTime::createFromFormat('d/m/Y', $eventDate);
        if ($dateTime) {
            $eventDate = $dateTime->format('Y-m-d'); // Convert to 'Y-m-d' format
        } else {
            throw new Exception('Invalid date format');
        }

        //var_dump($restaurantSession);

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $statement->bindParam(':eventDay', $eventDay, PDO::PARAM_STR);
        $statement->bindParam(':eventTimeStart', $eventTimeStart, PDO::PARAM_STR);
        $statement->bindParam(':eventTimeEnd', $eventTimeEnd, PDO::PARAM_STR);
        $statement->bindParam(':seatsTotal', $seatsTotal, PDO::PARAM_INT);
        $statement->bindParam(':seatsLeft', $seatsLeft, PDO::PARAM_INT);

        $success = $statement->execute();

        return $success;
    }

    public function deleteSession($sessionID)
    {
        $sql = "DELETE FROM restaurant_events WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $sessionID, PDO::PARAM_INT);
        $success = $statement->execute();

        return $success;
    }

    public function updateRestaurant($restaurant)
    {
        $sql = "UPDATE restaurants SET name = :name, address = :address, type = :type, price = :price, reduced = :reduced, stars = :stars, phoneNumber = :phoneNumber, email = :email, website = :website, chef = :chef WHERE id = :id";

        $restaurantName = $restaurant->getName();
        $restaurantAddress = $restaurant->getAddress();
        $restaurantType = $restaurant->getType();
        $restaurantPrice = $restaurant->getPrice();
        $restaurantReduced = $restaurant->getReduced();
        $restaurantStars = $restaurant->getStars();
        $restaurantPhoneNumber = $restaurant->getPhoneNumber();
        $restaurantEmail = $restaurant->getEmail();
        $restaurantWebsite = $restaurant->getWebsite();
        $restaurantChef = $restaurant->getChef();
        $restaurantID = $restaurant->getId();

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':name', $restaurantName, PDO::PARAM_STR);
        $statement->bindParam(':address', $restaurantAddress, PDO::PARAM_STR);
        $statement->bindParam(':type', $restaurantType, PDO::PARAM_STR);
        $statement->bindParam(':price', $restaurantPrice, PDO::PARAM_INT);
        $statement->bindParam(':reduced', $restaurantReduced, PDO::PARAM_INT);
        $statement->bindParam(':stars', $restaurantStars, PDO::PARAM_INT);
        $statement->bindParam(':phoneNumber', $restaurantPhoneNumber, PDO::PARAM_STR);
        $statement->bindParam(':email', $restaurantEmail, PDO::PARAM_STR);
        $statement->bindParam(':website', $restaurantWebsite, PDO::PARAM_STR);
        $statement->bindParam(':chef', $restaurantChef, PDO::PARAM_STR);
        $statement->bindParam(':id', $restaurantID, PDO::PARAM_INT);
        $success = $statement->execute();

        return $success;
    }

    public function updateImages($id, $imagePath)
    {
        $sql = "UPDATE restaurant_images SET image_path = :image_path WHERE id = :image_id";
        $updateStmt = $this->connection->prepare($sql);

        $updateStmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
        $updateStmt->bindParam(':image_id', $id, PDO::PARAM_STR);

        return $updateStmt->execute();
    }

    public function reserve($reservation)
    {
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

    public function getEventByID($id)
    {
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

    public function getAllReservations()
    {
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
            if ($row['enabled'] == 1) {
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

    public function updateReservation($reservation)
    {
        $sql = "UPDATE restaurant_reservations SET restaurantId = :restaurantId, eventID = :eventID, regularTickets = :regularTickets, reducedTickets = :reducedTickets, specialRequests = :specialRequests, enabled = :enabled WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        if ($reservation->getEnabled()) {
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

    public function deleteReservation($reservationID)
    {
        $sql = "DELETE FROM restaurant_reservations WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':id', $reservationID);

        return $statement->execute();
    }

    public function getLastReservationID()
    {
        $sql = "SELECT id FROM restaurant_reservations ORDER BY id DESC LIMIT 1";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $row = $statement->fetch();

        return $row['id'];
    }

    public function deleteRestaurant($restaurantID)
    {
        $sql = "DELETE FROM restaurants WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $restaurantID, PDO::PARAM_INT);
        $success = $statement->execute();

        if ($success) {
            return true;
        } else {
            return false;
        }
    }
}