<?php

namespace App\Controllers;

use App\Models\RestaurantReservation;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Services\RestaurantService;
use DateTime;
use Exception;

class YummyReservationController
{
    private $restaurantService;

    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
    }

    public function getRestaurantEvents()
    {
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);
        if ($jsonData !== null && isset($jsonData['restaurantID'])) {
            $restaurantID = intval($jsonData['restaurantID']);
            $restaurant = $this->restaurantService->getRestaurantByID($restaurantID);

            // Check if the restaurant object is not null before accessing its events
            if ($restaurant !== null) {
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

    public function reserve()
    {
        try {
            $jsonData = file_get_contents('php://input');
            $jsonData = json_decode($jsonData, true);

            if ($jsonData === null || !isset($jsonData['restaurantID'], $jsonData['regularTickets'], $jsonData['reducedTickets'], $jsonData['specialRequests'], $jsonData['eventID'])) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Invalid data']);
                return;
            }

            $reservation = new restaurantReservation();
            $reservation->setRestaurantId($jsonData['restaurantID']);
            $reservation->setEventID($jsonData['eventID']);
            $reservation->setRegularTickets(intval($jsonData['regularTickets']));
            $reservation->setReducedTickets(intval($jsonData['reducedTickets']));
            $reservation->setSpecialRequests($jsonData['specialRequests']);

            $event = $this->restaurantService->getEventByID($jsonData['eventID']);

            if ($event === null) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Event not found']);
                return;
            }

            if ($event->getSeatsLeft() < intval($jsonData['regularTickets']) + intval($jsonData['reducedTickets'])) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Not enough seats left']);
                return;
            }

            if ($this->restaurantService->reserve($reservation)) {
                echo json_encode(['success' => 'Reservation added']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['error' => 'Reservation not created']);
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Reservation not created from catch']);
        }
    }

    public function addTicket()
    {
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);
        //var_dump($jsonData);
        if ($jsonData !== null && isset($jsonData['restaurantID'], $jsonData['eventID'], $jsonData['regularTickets'], $jsonData['reducedTickets'], $jsonData['specialRequests'])) {
            $restaurantID = intval($jsonData['restaurantID']);
            $regularTickets = intval($jsonData['regularTickets']);
            $reducedTickets = intval($jsonData['reducedTickets']);
            $specialRequests = $jsonData['specialRequests'];
            $eventID = intval($jsonData['eventID']);

            $ticket = $this->createTicket($restaurantID, $eventID, $regularTickets, $reducedTickets, $specialRequests);
            if ($this->restaurantService->addTicket($ticket)) {
                echo json_encode(['success' => 'Ticket added']);
            } else {
                echo json_encode(['error' => 'Ticket not added']);
            }
        } else {
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    private function createTicket($restaurantID, $eventID, $regularTickets, $reducedTickets, $specialRequests)
    {
        $restaurant = $this->restaurantService->getRestaurantByID($restaurantID);
        $ticketType = TicketType::Yummy;
        $ticketName = $restaurant->getName();
        $location = $restaurant->getAddress();
        $description = $regularTickets . "/" . $reducedTickets . "/" . $specialRequests;
        $price = 10 * ($regularTickets + $reducedTickets);
        $event = $this->restaurantService->getEventByID($eventID);
        $startDateString = $event->getEventDate() . " " . $event->getEventTimeStart();
        $format = 'Y-m-d H:i:s';
        $startDate = DateTime::createFromFormat($format, $startDateString);
        $endDateString = $event->getEventDate() . " " . $event->getEventTimeEnd();
        $endDate = DateTime::createFromFormat($format, $endDateString);
        $lastID = $this->restaurantService->getLastReservationID();

        return new Ticket($lastID, $ticketName, $ticketType, "YUMMY EVENT", $location, $description, $price, $startDate, $endDate, 20); // I added 20 hard coded value for available tickets
    }


}