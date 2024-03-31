<?php
namespace App\Repositories;

use App\Models\Ticket;
use PDO;

class TicketRepository extends Repository
{

  public function getAllTickets()
  {
    $sql = "SELECT id, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date FROM ticket";
    $rows = $this->executeQuery($sql);
    if (!$rows) {
      echo "No tickets found.";
      return [];
    }
    return $this->mapToTicketObjects($rows);

  }

  public function mapToTicketObjects($rows)
  {
    $tickets = [];
    foreach ($rows as $row) {
      $id = $row['id'];
      $event_name = $row['event_name'];
      $ticket_Type = $row['ticket_Type'];
      $ticket_name = $row['ticket_name'];
      $location = $row['location'];
      $description = $row['description'];
      $price = $row['price'];
      $start_date = $row['start_date'];
      $end_date = $row['end_date'];
      $ticket = new Ticket($id, $event_name, $ticket_Type, $ticket_name, $location, $description, $price, $start_date, $end_date);
      $tickets[] = $ticket;

    }

  }

  public function addTicket(Ticket $ticket)
  {
    try {
      $stmt = $this->connection->prepare("INSERT INTO ticket (event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date) VALUES (:event_name, :ticket_Type, :ticket_name, :location, :description, :price, :start_date, :end_date)");
      //TODO: we should use getter and setter methods to get the values of the ticket object
      $event_name = $ticket->event_name;
      $ticket_Type = $ticket->ticket_Type->value;
      $ticket_name = $ticket->ticket_name;
      $location = $ticket->location;
      $description = $ticket->description;
      $price = $ticket->price;
      $start_date = $ticket->start_date->format('Y-m-d H:i:s');
      $end_date = $ticket->end_date->format('Y-m-d H:i:s');

      $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
      $stmt->bindParam(':ticket_Type', $ticket_Type, PDO::PARAM_INT);
      $stmt->bindParam(':ticket_name', $ticket_name, PDO::PARAM_STR);
      $stmt->bindParam(':location', $location, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
      $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);

      $stmt->execute();
      return true;
    } catch (\PDOException $e) {
      throw new \PDOException('Error adding ticket: ' . $e->getMessage());
    }
  }

  /*
  public function addArtist(Artist $artist){
        try {
            // Use a prepared statement to insert the artist into the database
            $stmt = $this->connection->prepare("INSERT INTO artist (artistName, style,description,title, participationDate, imageName) VALUES (:artistName, :style, :description, :title, :participationDate, :imageName)");
            $artistName = $artist->getArtistName();
            $style = $artist->getStyle();
            $description = $artist->getDescription();
            $title = $artist->getTitle();
            $imageName = $artist->getImageName();
            $participationDate = $artist->getParticipationDate();

            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':style', $style, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':participationDate', $participationDate, PDO::PARAM_STR);
            $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
            
            $stmt->execute();
            return true; // Return true if insertion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error adding artist: ' . $e->getMessage());
        }
    }
  */



}

