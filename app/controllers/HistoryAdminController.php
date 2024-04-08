<?php

namespace App\Controllers;
use App\Services\HistoryAdminService;
use App\Models\HistoryEntryTypeEnum;

class HistoryAdminController{
  private $historyAdminService;

  public function __construct(){
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
  
  public function addEntry() {
    $page_name = $_POST["page_name"];
    $entry_name = $_POST["entry_name"];
    $entry_type = $_POST["entry_type"];
    $content = $_POST["content"];

    if (empty($page_name) || empty($entry_name) || empty($entry_type) || empty($content)) {
      echo "Wrong input.";
    } else {
      $entry_type = $entry_type == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;;
      $this->historyAdminService->addEntry($page_name, $entry_name, $entry_type, $content);
      header("Location: /HistoryAdmin");
    }

    if ($entry_type == HistoryEntryTypeEnum::Image) {
      if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
          // Define the path to the upload directory
          $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/History/';
          $targetFile = $targetDirectory . basename($_FILES['image']['name']);
          // Move the uploaded file to your directory
          if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
              // File is successfully uploaded
              // You can now save the $targetFile (or a relative path) in your database
              $content = $targetFile; // Assuming you want to save the absolute path
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
    }
  }
  

  public function addTimeslot() {
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $english_tour = $_POST['english_tour'];
    $dutch_tour = $_POST['dutch_tour'];
    $chinese_tour = $_POST['chinese_tour'];

    $this->historyAdminService->addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);

    header("Location: /HistoryAdmin"); // Redirect back to the admin panel
  }

}