<?php

namespace App\Controllers;
use App\Services\DanceEventService;

class DanceEventController{
    private $danceEventService;
    
     function __construct()
    {
   //   echo "DanceEventController constructor called";
        $this->danceEventService = new DanceEventService();
    }
  
    public function index()
    {
      try {        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
        header("Content-Type: application/json"); 
      
          $danceEvent = $this->danceEventService->getAll();   
         // var_dump($danceEvent);
        // echo"TESTTTT index api";
          echo json_encode($danceEvent);
        
    } catch (\Exception $e) {
        // Debugging: Log any exceptions

        echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
    }
        
    }
}
