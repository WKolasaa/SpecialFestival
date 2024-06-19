<?php

namespace App\Services;

use App\Repositories\RestaurantRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserTicketRepository;
use Exception;

class RestaurantService
{
    private $restaurantRepository;

    public function __construct()
    {
        $this->restaurantRepository = new RestaurantRepository();
    }

    public function getRestaurants()
    {
        return $this->restaurantRepository->getRestaurants();
    }

    public function getRestaurantByID($restaurantID)
    {
        return $this->restaurantRepository->getRestaurantByID($restaurantID);
    }

    public function addRestaurant($restaurant)
    {
        return $this->restaurantRepository->addRestaurant($restaurant);
    }

    public function updateSession($restaurantSession)
    {
        return $this->restaurantRepository->updateSession($restaurantSession);
    }

    public function addSession($restaurantSession)
    {
        return $this->restaurantRepository->addSession($restaurantSession);
    }

    public function deleteSession($sessionID)
    {
        return $this->restaurantRepository->deleteSession($sessionID);
    }

    public function updateRestaurant($restaurant)
    {
        return $this->restaurantRepository->updateRestaurant($restaurant);
    }

    public function updateImage($id, $imagePath)
    {
        return $this->restaurantRepository->updateImages($id, $imagePath);
    }

    public function getEventByID($id)
    {
        return $this->restaurantRepository->getEventByID($id);
    }

    public function reserve($reservation)
    {
        return $this->restaurantRepository->reserve($reservation);
    }

    public function getAllReservations()
    {
        return $this->restaurantRepository->getAllReservations();
    }

    public function updateReservation($reservation)
    {
        return $this->restaurantRepository->updateReservation($reservation);
    }

    public function deleteReservation($reservationID)
    {
        return $this->restaurantRepository->deleteReservation($reservationID);
    }

    public function addTicket($ticket)
    {
        try {
            session_start();
            $ticketRepository = new TicketRepository();
            $ticketRepository->addTicket($ticket);
            $userTicketRepository = new UserTicketRepository();
            $user = $_SESSION['userId'];
            $userTicketRepository->addUserTicket($ticket, $user);
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getLastReservationID()
    {
        return $this->restaurantRepository->getLastReservationID();
    }

    public function deleteRestaurant($restaurantID)
    {
        return $this->restaurantRepository->deleteRestaurant($restaurantID);
    }
}