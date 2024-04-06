<?php
namespace App\Repositories;

use App\Models\Ticket;
use App\Models\TicketType;
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
    // var_dump($this->mapToTicketObjects($rows));
    return $this->mapToTicketObjects($rows);


  }



  public function mapToTicketObjects($rows)
  {
    $tickets = [];
    foreach ($rows as $row) {
      $id = $row['id'];
      $event_name = $row['event_name'];
      $ticket_Type = match ($row['ticket_Type']) {
        1 => TicketType::Dance,
        2 => TicketType::Yummy,
        3 => TicketType::History,
        default => throw new \Exception("Invalid ticket type"),
      };
      $ticket_name = $row['ticket_name'];
      $location = $row['location'];
      $description = $row['description'];
      $price = $row['price'];
      $start_date = new \DateTime($row['start_date']);
      $end_date = new \DateTime($row['end_date']);
      $ticket = new Ticket($id, $event_name, $ticket_Type, $ticket_name, $location, $description, $price, $start_date, $end_date);
      $tickets[] = $ticket;
    }

    return $tickets; // Return the tickets array
  }

  public function addTicket(Ticket $ticket)
  {
    try {
      $stmt = $this->connection->prepare("INSERT INTO ticket (event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date) VALUES (:event_name, :ticket_Type, :ticket_name, :location, :description, :price, :start_date, :end_date)");
      //TODO: we should use getter and setter methods to get the values of the ticket object
      $event_name = $ticket->getEventName();
      $ticket_Type = $ticket->getTicketType()->value;
      $ticket_name = $ticket->getTicketName();
      $location = $ticket->getLocation();
      $description = $ticket->getDescription();
      $price = $ticket->getPrice();
      $start_date = $ticket->getStartDate()->format('Y-m-d H:i:s');
      $end_date = $ticket->getEndDate()->format('Y-m-d H:i:s');

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





}

