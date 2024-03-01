<?php
namespace App\Repositories;
use App\Models\DanceEvent;

use PDO;

class DanceEventRepository extends Repository{

  function getAll(){
    $sql = "SELECT event_date, day_of_week, event_time, venue, performers, event_session, event_duration_minutes, capacity, tickets_available, ticket_price, additional_info, venue_address, artist_styles FROM DanceEvents";
    $rows=$this->executeQuery($sql);
    if (!$rows) {
      echo "No events found.";
      return [];
    }
    return $this->mapToDanceEventObjects($rows);

  }
  private function mapToDanceEventObjects($rows)
  {
      $danceEvents = [];

      foreach ($rows as $row) {
          $danceEvents[] = new DanceEvent(
              $row['event_date'],
              $row['day_of_week'],
              $row['event_time'],
              $row['venue'],
              $row['performers'],
              $row['event_session'],
              $row['event_duration_minutes'],
              $row['capacity'],
              $row['tickets_available'],
              $row['ticket_price'],
              $row['additional_info'],
              $row['venue_address'],
              $row['artist_styles']
          );

       
      }

      return $danceEvents;
  }

private function executeQuery($sql)
{
    try {
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        throw new \PDOException("Query execution failed: " . $e->getMessage());
    }
}
}