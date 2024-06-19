<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;
use App\Models\HistoryEntryTypeEnum;
use Exception;

class HistoryAdminController
{
  private $historyAdminService;

  public function __construct()
  {
    $this->historyAdminService = new HistoryAdminService();
  }


  public function index()
  {
    $entries = $this->historyAdminService->getAll();
    $timeslots = $this->historyAdminService->getAllTimeslots(); // Get all timeslots
    include '../views/AdminViews/HistoryAdmin.php';
  }

  public function timeslots()
    {
      $entries = $this->historyAdminService->getAll();
      include '../views/HistoryView/EditTimeslots.php';
      
    }
  
    public function addTimeslot() {
      $day = $_POST['day'];
      $start_time = $_POST['start_time'];
      $end_time = $_POST['end_time'];
      $english_tour = $_POST['english_tour'];
      $dutch_tour = $_POST['dutch_tour'];
      $chinese_tour = $_POST['chinese_tour'];
  
      $this->historyAdminService->addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
  
      header("Location: /AdminView/history"); // Redirect back to the admin panel
    }
}