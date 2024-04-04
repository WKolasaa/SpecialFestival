<?php

namespace App\Services;

use App\Repositories\RestaurantRepository;

class restaurantservice
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

    public function updateImages($images){
        return $this->restaurantRepository->updateImages($images);
    }
}