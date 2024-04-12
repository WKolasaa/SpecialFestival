<?php

namespace App\Repositories;
use App\Models\HistoryCMSEntry;
use App\Models\HistoryEntryTypeEnum;

use PDOException;
use PDO;

class HistoryAdminRepository extends Repository
{
  ////////////////// Retrieves all entries from the history_contents table //////////////////
  // Returns an array of HistoryCMSEntry objects
    public function getAll() {
      //sql query is stored in a variable called $sql
      $sql = "SELECT id, page_name, entry_name, entry_type, content FROM history_contents";
      //$this->connection represents a PDO connection to the database. 
      //prepare is a PDO method that prepares the SQL statement for execution, preventing SQL injection
      $statement = $this->connection->prepare($sql);

      try {
        $statement->execute();
        //Retrieves all rows from the query result as an associative array where the column names are keys
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        //initializing empty array to store instances of HistoryCMSEntry objects
        $entries = [];
        foreach ($rows as $row) {
          // Determines the entry_type by comparing the value in $row["entry_type"].
          $entry_type = $row["entry_type"] == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;
          // Creates a new instance of HistoryCMSEntry with the data from the current row and adds it to the $entries array
          $entries[] = new HistoryCMSEntry($row["id"], $row["page_name"], $row["entry_name"], $entry_type, $row["content"]);
        }
        
        // returns array of HistoryCMSEntry objects
        return $entries;
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      
      }
    }

////////////////// Fetches the content for a specific entry from the history_contents table //////////////////
    public function getContent($page_name, $entry_name) {
      //This line defines a SQL query that selects the content field from the history_contents table where the page_name and entry_name match specified parameters. 
      //The use of named placeholders (:page_name, :entry_name) in the SQL query prevents SQL injection 
      $sql = "SELECT content FROM history_contents WHERE page_name = :page_name AND entry_name = :entry_name";
      $statement = $this->connection->prepare($sql);
      
      try {
          //The bindParam method binds variables page_name and enrtry_name to the respective placeholders in sql query.
          $statement->bindParam(':page_name', $page_name);
          $statement->bindParam(':entry_name', $entry_name);
          
          $statement->execute();
          //Retrieves a single row from the result set as an associative array
          $row = $statement->fetch(PDO::FETCH_ASSOC);
          //This handling ensures that the method either returns the actual content or a clear indicator that no content was found.
          if ($row && !empty($row['content'])) {
              return $row["content"];
          } else {
              return "<null>";
          }

      } catch (PDOException $e) {
          echo "ERROR LOADING " . $entry_name;
      }
  }

  //////////////////Updates the content of an entry in the history_contents table //////////////////
  // @$entry_id The ID of the entry to update.
  // $content The new content for the entry.
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

  ////////////////// Retrieves the content of an entry by its ID from the history_contents table //////////////////
  public function getEntryContent($entry_id) {
    $sql = "SELECT content FROM history_contents WHERE id = :entry_id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(":entry_id", $entry_id, PDO::PARAM_INT);
    try {
        $statement->execute();
        //Fetches the next row from the result set returned by the execute statement
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        //If a record is found, it returns the content of that record; otherwise, it returns null. 
        return $row ? $row["content"] : null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
  } 

  ////////////////// Inserts a new timeslot (each day has 3 timeslots) into the history_timeslots table //////////////////
  public function addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour) {
    $sql = "INSERT INTO history_timeslots (day, start_time, end_time, english_tour, dutch_tour, chinese_tour) VALUES (:day, :start_time, :end_time, :english_tour, :dutch_tour, :chinese_tour);";
    $statement = $this->connection->prepare($sql);

    //These lines bind the method parameters to the corresponding placeholders in the SQL statement    $statement->bindParam(":day", $day);
    $statement->bindParam(":start_time", $start_time);
    $statement->bindParam(":end_time", $end_time);
    $statement->bindParam(":english_tour", $english_tour);
    $statement->bindParam(":dutch_tour", $dutch_tour);
    $statement->bindParam(":chinese_tour", $chinese_tour);

    $statement->execute();
  }

  ////////////////// Retrieves all timeslots from the history_timeslots table //////////////////
  public function getAllTimeslots() {
    $sql = "SELECT id, day, start_time, end_time, english_tour, dutch_tour, chinese_tour FROM history_timeslots ORDER BY id ASC;";
    $statement = $this->connection->prepare($sql);
    //Executes the prepared SQL statement. Since there are no parameters to bind in this query, the execute method is called without arguments.
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  ////////////////// Updates the details of a specific timeslot in the history_timeslots table //////////////////
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

    //If rowCount returns more than zero, it implies that the update was successful and affected at least one row
    return $statement->rowCount() > 0;
  }

  ////////////////// Retrieves a specific timeslot by its ID from the history_timeslots table //////////////////
  public function getTimeslotById($id) {
    $sql = "SELECT * FROM history_timeslots WHERE id = :id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC); 
  }

  ////////////////// Deletes a timeslot from the history_timeslots table using its ID //////////////////
  public function deleteTimeslot($id) {
    $sql = "DELETE FROM history_timeslots WHERE id = :id";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    
    try {
        $statement->execute();
        return $statement->rowCount() > 0;  // Return true if the timeslot was successfully deleted
    } catch (PDOException $e) {
        error_log("Error when trying to delete timeslot: " . $e->getMessage());
        return false;  // Return false on error
    }
  }

}