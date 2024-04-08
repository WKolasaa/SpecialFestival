<?php
namespace App\Services;

use App\Repositories\HistoryAdminRepository;

class HistoryAdminService {

private $historyAdminRepository;

  function __construct()
  {
      $this->historyAdminRepository = new HistoryAdminRepository();
  }

  public function getAll() {
    return $this->historyAdminRepository->getAll();
  }

  public function getContent($page_name, $entry_name) {
    return $this->historyAdminRepository->getContent($page_name, $entry_name);
  }

  public function addEntry($page_name, $entry_name, $entry_type, $content) {
    $this->historyAdminRepository->addEntry($page_name, $entry_name, $entry_type, $content);
  }
  
  public function updateEntry($entry_id, $content) {
    $this->historyAdminRepository->updateEntry($entry_id, $content);
  }

  public function deleteEntry($entry_id) {
    $this->historyAdminRepository->deleteEntry($entry_id);
  }
  
  public function getEntryContent($entry_id) {
    return $this->historyAdminRepository->getEntryContent($entry_id);
  }

  public function addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour) {
    $this->historyAdminRepository->addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
  }

  public function getAllTimeslots() {
    return $this->historyAdminRepository->getAllTimeslots();
  }

  public function updateTimeslot($id, $day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour) {
    return $this->historyAdminRepository->updateTimeslot($id, $day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
  }

  public function getTimeslotById($id) {
    return $this->historyAdminRepository->getTimeslotById($id);
  }

  public function addTicket($ticketData) {
    return $this->historyAdminRepository->addTicket($ticketData);
  }
}