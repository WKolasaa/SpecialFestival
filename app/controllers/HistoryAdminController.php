<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;

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

  public function addTimeslot()
  {
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $english_tour = $_POST['english_tour'];
    $dutch_tour = $_POST['dutch_tour'];
    $chinese_tour = $_POST['chinese_tour'];

    // Ensure all expected inputs are present
    if (
      empty($day) || empty($start_time) || empty($end_time) ||
      empty($english_tour) || empty($dutch_tour) || empty($chinese_tour)
    ) {
      throw new \Exception("Missing input fields");
    }

   $results= $this->historyAdminService->addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
    if($results)
    {
      header('Location: /AdminView/history');
    }
    else
    {
      echo "Error: Timeslot already exists";
      header('Location: /AdminView/history');

    }
    exit;
  }

}