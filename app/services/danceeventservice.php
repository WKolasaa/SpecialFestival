<?php
namespace App\Services;

use App\Repositories\DanceEventRepository;
// use App\Models\DanceEvent;

class DanceEventService{

private $danceEventRepository;

  function __construct()
  {
      $this->danceEventRepository = new DanceEventRepository();
  }

  public function getAll()
  {
    //echo "DanceEventService getAll called";
      return $this->danceEventRepository->getAll();
  }
}