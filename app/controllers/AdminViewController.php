<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;
use App\Services\HomeContentService;
use App\Services\OrderService;
use App\Services\RestaurantService;


class AdminViewController
{

   private $orderService;
   private HistoryAdminService $historyService;
   private HomeContentService $homeContentService;


   function __construct()
   {
       $this->orderService = new OrderService();
       $this->historyService = new HistoryAdminService();
       $this->homeContentService = new HomeContentService();
   }
   public function index()
   {
      $events = $this->homeContentService->getAllEvents(); 
      $entries = $this->homeContentService->getAll();
      include '../views/adminViews/HomeAdmin.php';
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
   
   public function history()
   {
       $entries = $this->historyService->getAll();
       $timeslots = $this->historyService->getAllTimeslots();
       include '../views/adminViews/HistoryAdmin.php';
   }

   public function orders()
   {
       $orders = $this->orderService->getAllOrders();
      // var_dump($orders);
      include '../views/adminViews/ordersadmin.php';


   }
   public function manageUser()
   {
      include '../views/adminViews/manageusers.php';
   }

}

