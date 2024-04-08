<?php
namespace App\Services;

use App\Repositories\HomeContentRepository;

class HomeContentService {

private $homeContentRepository;

  function __construct()
  {
      $this->homeContentRepository = new HomeContentRepository();
  }

  public function getAll() {
    return $this->homeContentRepository->getAll();
  }

  public function getContent($content_name) {
    return $this->homeContentRepository->getContent($content_name);
  }

  public function addEntry($content_name, $content_type, $content) {
    $this->homeContentRepository->addEntry($content_name, $content_type, $content);
  }
  
  public function updateEntry($id, $content) {
    $this->homeContentRepository->updateEntry($id, $content);
  }

  public function deleteEntry($id) {
    $this->homeContentRepository->deleteEntry($id);
  }
  
  public function getEntryContent($id) {
    return $this->homeContentRepository->getEntryContent($id);
}

}