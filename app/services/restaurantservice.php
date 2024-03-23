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
}