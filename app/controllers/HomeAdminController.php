<?php

namespace App\Controllers;
use App\Services\HomeContentService;
use App\Models\HistoryEntryTypeEnum;

class HomeAdminController{
  private $homeContentService;

  public function __construct(){
    $this->homeContentService = new HomeContentService();
  }

  public function index()
  {
    error_log("Index method called.");
    $entries = $this->homeContentService->getAll();
    var_dump($entries);
    include '../views/adminViews/HomeAdmin.php';
  }

  public function addEntry() {
    $content_name = $_POST["content_name"];
    $content_type = $_POST["content_type"];
    $content = $_POST["content"];

    if (empty($content_name) || empty($content_type) || empty($content)) {
      echo "Wrong input.";
    } else {
      $content_type = $content_type == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;;
      $this->homeContentService->addEntry($content_name, $content_type, $content);
      header("Location: /HomeAdmin");
    }

    if ($content_type == HistoryEntryTypeEnum::Image) {
      if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
          // Define the path to the upload directory
          $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/Home/';
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
  
}