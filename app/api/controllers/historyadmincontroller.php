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
}
