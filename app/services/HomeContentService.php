<?php

namespace App\Services;

use App\Repositories\HomeContentRepository;

class HomeContentService
{

    private $homeContentRepository;

    function __construct()
    {
        $this->homeContentRepository = new HomeContentRepository();
    }

    public function getAll()
    {
        return $this->homeContentRepository->getAll();
    }

    public function getContent($content_name)
    {
        return $this->homeContentRepository->getContent($content_name);
    }

    public function addEntry($content_name, $content_type, $content)
    {
        $this->homeContentRepository->addEntry($content_name, $content_type, $content);
    }

    public function updateEntry($id, $content)
    {
        $this->homeContentRepository->updateEntry($id, $content);
    }

    public function deleteEntry($id)
    {
        $this->homeContentRepository->deleteEntry($id);
    }

    public function getEntryContent($id)
    {
        return $this->homeContentRepository->getEntryContent($id);
    }

public function getEventsByDate($date) {
  return $this->homeContentRepository->getEventsByDate($date);
}

public function addEvent($name, $description, $date, $startTime, $endTime) {
  return $this->homeContentRepository->addEvent($name, $description, $date, $startTime, $endTime);
}

public function getLastInsertId() {
  return $this->homeContentRepository->getLastInsertId();
}

public function getAllEvents() {
  return $this->homeContentRepository->getAllEvents(); // This method should query the database and return an array of events
}

// Update an event
public function updateEvent($id, $name, $description, $date, $startTime, $endTime) {
  return $this->homeContentRepository->updateEvent($id, $name, $description, $date, $startTime, $endTime);
}

// Delete an event
public function deleteEvent($id) {
  return $this->homeContentRepository->deleteEvent($id);
}
}