<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;
use App\Services\OrderService;
use App\Services\RestaurantService;


class AdminViewController
{

   private $orderService;
   private HistoryAdminService $historyService;


   function __construct()
   {
       $this->orderService = new OrderService();
       $this->historyService = new HistoryAdminService();
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
       $entries = $this->historyService->getAll();
       $timeslots = $this->historyService->getAllTimeslots();
       include '../views/adminViews/HistoryAdmin.php';
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

