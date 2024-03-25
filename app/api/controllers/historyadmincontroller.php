<?php

namespace App\Controllers;
use App\Services\HistoryAdminService;

class HistoryAdminController{
    private $historyAdminService;
    
     function __construct()
    {
        $this->historyAdminService = new HistoryAdminService();
    }

    public function update() {
      $entry_id = $_POST["entry_id"];
      $content = $_POST["content"];
      $this->historyAdminService->updateEntry($entry_id, $content);
    }
  
    public function delete() {
      $entry_id = $_GET["entry_id"];
      $this->historyAdminService->deleteEntry($entry_id);
    }

    public function updateImage() {
      $entry_id = $_POST["entry_id"];
      
      if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
          $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/History/';
          $targetFile = $targetDirectory . basename($_FILES['image']['name']);

          if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
              // Assuming you want to save just the file name or relative path
              $relativePath = '/img/History/' . basename($_FILES['image']['name']);
              $this->historyAdminService->updateEntry($entry_id, $relativePath);
              echo "Image updated successfully.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      } else {
          echo "No file uploaded or an error occurred.";
      }
    }
}
