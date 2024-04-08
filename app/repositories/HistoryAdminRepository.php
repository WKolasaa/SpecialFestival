<?php

namespace App\Repositories;
use App\Models\HistoryCMSEntry; // importing classes and exceptions
use App\Models\HistoryEntryTypeEnum;

use PDOException;
use PDO;


// CREATE TABLE history_contents (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   page_name VARCHAR(100) NOT NULL,
//   entry_name VARCHAR(100) NOT NULL,
//   entry_type VARCHAR(100) NOT NULL,
//   content TEXT,
//   UNIQUE(page_name, entry_name)
// );

class HistoryAdminRepository extends Repository
{

    public function getAll() {
      $sql = "SELECT id, page_name, entry_name, entry_type, content FROM history_contents";
      $statement = $this->connection->prepare($sql);

      try {
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $entries = [];
        foreach ($rows as $row) {
          $entry_type = $row["entry_type"] == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;
          $entries[] = new HistoryCMSEntry($row["id"], $row["page_name"], $row["entry_name"], $entry_type, $row["content"]);
        }
        
        return $entries;
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      
      }
    }

    public function getContent($page_name, $entry_name) {
      $sql = "SELECT content FROM history_contents WHERE page_name = :page_name AND entry_name = :entry_name";
      $statement = $this->connection->prepare($sql);
      
      try {
          $statement->bindParam(':page_name', $page_name);
          $statement->bindParam(':entry_name', $entry_name);
          
          $statement->execute();
          $row = $statement->fetch(PDO::FETCH_ASSOC);
          
          if ($row && !empty($row['content'])) {
              return $row["content"];
          } else {
              return "<null>";
          }

      } catch (PDOException $e) {
          echo "ERROR LOADING " . $entry_name;
      }
  }

  public function addEntry($page_name, $entry_name, $entry_type, $content) {
    $sql = "INSERT INTO history_contents (page_name, entry_name, entry_type, content) VALUES (:page_name, :entry_name, :entry_type, :content);";
    $statement = $this->connection->prepare($sql);

    $statement->bindParam(":page_name", $page_name, PDO::PARAM_STR);
    $statement->bindParam(":entry_name", $entry_name, PDO::PARAM_STR);

    $entry_type = $entry_type == HistoryEntryTypeEnum::Text ? "TEXT" : "IMAGE";
    $statement->bindParam(":entry_type", $entry_type, PDO::PARAM_STR);
    
    $statement->bindParam(":content", $content, PDO::PARAM_STR);

    try{
      $statement->execute();
    }catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  public function updateEntry($entry_id, $content) {
    $sql = "UPDATE history_contents SET content = :content WHERE id = :entry_id;";

    $statement = $this->connection->prepare($sql);

    try{
      $statement->bindParam(":entry_id", $entry_id, PDO::PARAM_INT);
      $statement->bindParam(":content", $content, PDO::PARAM_STR);
      $statement->execute();
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }    
  }

  public function deleteEntry($entry_id) {
    $sql = "DELETE FROM history_contents WHERE id = :entry_id";

    $statement = $this->connection->prepare($sql);

    try{
      $statement->bindParam(":entry_id", $entry_id, PDO::PARAM_INT);
      $statement->execute();
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function getEntryContent($entry_id) {
    $sql = "SELECT content FROM history_contents WHERE id = :entry_id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(":entry_id", $entry_id, PDO::PARAM_INT);
    try {
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? $row["content"] : null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
  } 

  public function addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour) {
    $sql = "INSERT INTO history_timeslots (day, start_time, end_time, english_tour, dutch_tour, chinese_tour) VALUES (:day, :start_time, :end_time, :english_tour, :dutch_tour, :chinese_tour);";
    $statement = $this->connection->prepare($sql);

    $statement->bindParam(":day", $day);
    $statement->bindParam(":start_time", $start_time);
    $statement->bindParam(":end_time", $end_time);
    $statement->bindParam(":english_tour", $english_tour);
    $statement->bindParam(":dutch_tour", $dutch_tour);
    $statement->bindParam(":chinese_tour", $chinese_tour);

    $statement->execute();
  }

  public function getAllTimeslots() {
    $sql = "SELECT id, day, start_time, end_time, english_tour, dutch_tour, chinese_tour FROM history_timeslots ORDER BY id ASC;";
    $statement = $this->connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateTimeslot($id, $day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour) {
    $sql = "UPDATE history_timeslots SET day = :day, start_time = :start_time, end_time = :end_time, english_tour = :english_tour, dutch_tour = :dutch_tour, chinese_tour = :chinese_tour WHERE id = :id";
    $statement = $this->connection->prepare($sql);
    $statement->execute([
        ':day' => $day,
        ':start_time' => $start_time,
        ':end_time' => $end_time,
        ':english_tour' => $english_tour,
        ':dutch_tour' => $dutch_tour,
        ':chinese_tour' => $chinese_tour,
        ':id' => $id,
    ]);

    return $statement->rowCount() > 0;
  }

  public function getTimeslotById($id) {
    $sql = "SELECT * FROM history_timeslots WHERE id = :id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC); // Assuming only one record will be returned
  }

}