<?php

namespace App\Repositories;
use App\Models\HomeCMSEntry; 
use App\Models\HistoryEntryTypeEnum;
use App\Models\HomeEvent;

use PDOException;
use PDO;

class HomeContentRepository extends Repository
{

  public function getAll() {
    $sql = "SELECT id, content_name, content_type, content FROM home_contents";
    $statement = $this->connection->prepare($sql);
    $entries = [];

    try {
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $content_type = $row["content_type"] == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;
            $entry = new HomeCMSEntry();
            $entry->setId($row["id"]);
            $entry->setContentName($row["content_name"]);
            $entry->setContentType($content_type);
            $entry->setContent($row["content"]);
            $entries[] = $entry;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    return $entries;
}

    public function getContent($content_name) {
      $sql = "SELECT content FROM home_contents WHERE content_name = :content_name";
      $statement = $this->connection->prepare($sql);
      
      try {
          $statement->bindParam(':content_name', $content_name, PDO::PARAM_STR);
          $statement->execute();
          $row = $statement->fetch(PDO::FETCH_ASSOC);
          
          if ($row && !empty($row['content'])) {
              return $row["content"];
          } else {
              return "<null>";
          }

      } catch (PDOException $e) {
          echo "ERROR LOADING " . $content_name;
      }
  }

  public function addEntry($content_name, $content_type, $content) {
    $sql = "INSERT INTO home_contents (content_name, content_type, content) VALUES (:content_name, :content_type, :content);";
    $statement = $this->connection->prepare($sql);

    $statement->bindParam(":content_name", $content_name, PDO::PARAM_STR);

    $content_type = $content_type == HistoryEntryTypeEnum::Text ? "TEXT" : "IMAGE";
    $statement->bindParam(":content_type", $content_type, PDO::PARAM_STR);
    
    $statement->bindParam(":content", $content, PDO::PARAM_STR);

    try{
      $statement->execute();
    }catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  public function updateEntry($id, $content) {
    $sql = "UPDATE home_contents SET content = :content WHERE id = :id;";

    $statement = $this->connection->prepare($sql);

    try{
      $statement->bindParam(":id", $id, PDO::PARAM_INT);
      $statement->bindParam(":content", $content, PDO::PARAM_STR);
      $statement->execute();
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }    
  }

  public function deleteEntry($id) {
    $sql = "DELETE FROM home_contents WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    try{
      $statement->bindParam(":id", $id, PDO::PARAM_INT);
      $statement->execute();
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function getEntryContent($id) {
    $sql = "SELECT content FROM home_contents WHERE id = :id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    try {
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? $row["content"] : null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

public function getEventsByDate($date) {
  $sql = "SELECT event_name, event_description, start_time, end_time FROM festival_events WHERE event_date = :event_date ORDER BY start_time ASC";
  $statement = $this->connection->prepare($sql);
  $statement->bindParam(':event_date', $date, PDO::PARAM_STR);
  $events = [];

  try {
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      foreach ($rows as $row) {
          $events[] = $row;
      }
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  return $events;
}

public function addEvent($eventName, $eventDescription, $eventDate, $startTime, $endTime) {
  $sql = "INSERT INTO festival_events (event_name, event_description, event_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
  $statement = $this->connection->prepare($sql);
  $success = $statement->execute([$eventName, $eventDescription, $eventDate, $startTime, $endTime]);
  return $success ? $this->connection->lastInsertId() : false;
}

public function getLastInsertId() {
  return $this->connection->lastInsertId();
}


public function getAllEvents() {
  $sql = "SELECT id, event_name, event_description, event_date, start_time, end_time FROM festival_events ORDER BY event_date, start_time ASC";
  $statement = $this->connection->prepare($sql);
  $events = [];

  try {
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      foreach ($rows as $row) {
          $event = new HomeEvent();
          $event->setId($row["id"]);
          $event->setName($row["event_name"]);
          $event->setDescription($row["event_description"]);
          $event->setDate($row["event_date"]);
          $event->setStartTime($row["start_time"]);
          $event->setEndTime($row["end_time"]);
          $events[] = $event;
      }
  } catch (PDOException $e) {
      error_log('PDOException - ' . $e->getMessage(), 0);
  }

  return $events;
}

// Update an event in the database
public function updateEvent($id, $name, $description, $date, $startTime, $endTime) {
  $sql = "UPDATE festival_events SET event_name = ?, event_description = ?, event_date = ?, start_time = ?, end_time = ? WHERE id = ?";
  $statement = $this->connection->prepare($sql);
  return $statement->execute([$name, $description, $date, $startTime, $endTime, $id]);
}

// Delete an event from the database
public function deleteEvent($id) {
  $sql = "DELETE FROM festival_events WHERE id = ?";
  $statement = $this->connection->prepare($sql);
  return $statement->execute([$id]);
}

}