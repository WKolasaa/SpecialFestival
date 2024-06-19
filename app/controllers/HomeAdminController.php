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
}