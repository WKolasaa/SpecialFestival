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
    include '../views/HistoryView/HistoryAdmin.php';
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
  }
}