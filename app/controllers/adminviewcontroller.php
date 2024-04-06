<?php

namespace App\Controllers;

use App\Services\OrderService;
use App\Services\restaurantservice;


class AdminViewController
{

   private $orderService;


   function __construct()
   {
      $this->orderService = new OrderService();
   }
   public function index()
   {
      include '../views/home.php';

   }
   public function dance()
   {            //ADMIN CONTROLLER
      include '../views/adminViews/danceEventadmin.php';

   }
   public function yummy()
   {
      try{
         $restaurantService = new RestaurantService();
         $restaurants = $restaurantService->getRestaurants();
     }
     catch (\Exception $e) {
         $error = $e->getMessage();
     }
     include '../views/adminViews/yummyEventadmin.php';
   }
   
   public function history() //TODO: SLAVA check your route here
   {
      include '../views/adminViews/ordersadmin.php';

   }

   public function orders()
   {
      $orders = $this->orderService->getAllTickets();
      include '../views/adminViews/ordersadmin.php';


   }
   public function manageUser()
   {
      include '../views/adminViews/manageusers.php';
   }

}

