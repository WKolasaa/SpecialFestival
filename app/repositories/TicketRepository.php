<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\TicketType;
use DateTime;
use Exception;
use PDO;
use PDOException;

class TicketRepository extends Repository
{
    public function getTicketById(int $id): ?Ticket
    {
        $sql = "SELECT id, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date FROM ticket WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) {
            echo "No ticket found.";
            return null;
        }
        return $this->rowToTicket($row);
    }



    public function getAllTickets()
    {
        $sql = "SELECT id, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date FROM ticket";
        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No tickets found.";
            return [];
        }
        return $this->rowToTickets($rows);
    }

    public function rowToTicket($row): ?Ticket
    {
        try {
            return new Ticket(
                $row['id'],
                $row['event_name'],
                TicketType::from($row['ticket_Type']),
                $row['ticket_name'],
                $row['location'],
                $row['description'],
                $row['price'],
                new DateTime($row['start_date']),
                new DateTime($row['end_date'])
            );
        } catch (Exception $e) {
            echo "Error creating ticket: " . $e->getMessage();
            return null;
        }
    }

    public function rowToTickets($rows): array
    {
        $tickets = [];
        foreach ($rows as $row) {
            $tickets[] = $this->rowToTicket($row);
        }
        return $tickets;
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
        } catch (PDOException $e) {
            throw new PDOException('Error adding ticket: ' . $e->getMessage());
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

