<?php
namespace App\Repositories;
use App\Models\Artist;
use App\Models\Agenda;
use App\Models\Ticket;

use PDO;

class DanceEventRepository extends Repository{
    public function getAllArtists(){
        $sql = "SELECT artistId, artistName, style, participationDate FROM artist";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No artists found.";
            return [];
          }
            return $this->mapToArtistObjects($rows);
    }

    public function getAllAgendas(){
        $sql = "SELECT agendaId, artistName, eventDay, eventDate, eventTime, durationMinutes, ticketPrice, ticketsAvailable, venueAddress FROM agenda";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No agendas found.";
            return [];
          }
            return $this->mapToAgendaObjects($rows);
    }

    public function getAllTickets(){
        $sql = "SELECT ticketId, artistName, sessionTime, sessionDate, venue, ticketPrice FROM tickets";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No tickets found.";
            return [];
          }
            return $this->mapToTicketObjects($rows);
    }





    private function mapToTicketObjects($rows){
        $tickets = [];
        foreach ($rows as $row) {
            $ticketId=$row['ticketId'];
            $artistName=$row['artistName'];
            $sessionTime=$row['sessionTime'];
            $sessionDate=$row['sessionDate'];
            $venue=$row['venue'];
            $ticketPrice=$row['ticketPrice'];
            $ticket = new Ticket($ticketId,$artistName,$sessionTime,$sessionDate,$venue,$ticketPrice);
            $tickets[] = $ticket;
        }
        return $tickets;
    }



    private function mapToAgendaObjects($rows){

        $agendas = [];
        foreach ($rows as $row) {
            $agendaId=$row['agendaId'];
            $artistName=$row['artistName'];
            $eventDay=$row['eventDay'];
            $eventDate=$row['eventDate'];
            $eventTime=$row['eventTime'];
            $durationMinutes=$row['durationMinutes'];
            $ticketPrice=$row['ticketPrice'];
            $ticketsAvailable=$row['ticketsAvailable'];
            $venueAddress=$row['venueAddress'];
            $agenda = new Agenda($agendaId, $artistName, $eventDay, $eventDate, $eventTime, $durationMinutes, $ticketPrice, $ticketsAvailable, $venueAddress);
            $agendas[] = $agenda;
        }
        return $agendas;
    }

    private function mapToArtistObjects($rows){
        $artists = [];
        foreach ($rows as $row) {

            $artistId=$row['artistId'];
            $artistName=$row['artistName'];
            $style=$row['style'];
            $participationDate=$row['participationDate'];
            $artist = new Artist($artistId, $artistName, $style, $participationDate);
            $artists[] = $artist;
        }
        return $artists;
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
///////////////////////////update///////////////////////////
    public function updateArtist(Artist $artist) {
        // var_dump($artist);
        // Prepare the SQL statement with placeholders
        $sql = "UPDATE artist SET artistName = :artistName, style = :style, participationDate = :participationDate WHERE artistId = :artistId";
    
        // Get values from the artist object
        $artistId = $artist->getArtistId();
        $artistName = $artist->getArtistName();
        $style = $artist->getStyle();
        $participationDate = $artist->getParticipationDate();
    
        // Manually construct a debug SQL string
        $debugSql = "UPDATE artist SET artistName = '{$artistName}', style = '{$style}', participationDate = '{$participationDate}' WHERE artistId = {$artistId}";
    
        // Echo the debug SQL string
        echo "Debug SQL: " . $debugSql . "\n";
    
        // Proceed with the actual prepared statement execution
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $statement->bindParam(':artistName', $artistName, PDO::PARAM_STR);
        $statement->bindParam(':style', $style, PDO::PARAM_STR);
        $statement->bindParam(':participationDate', $participationDate, PDO::PARAM_STR);
    
        if ($statement->execute()) {
            echo "Statement executed successfully.\n";
            if ($statement->rowCount() > 0) {
                echo "Artist information updated successfully.\n";
            } else {
                echo "No rows were affected, possibly because the artist ID was not found.\n";
            }
        } else {
            echo "Statement execution failed.\n";
            var_dump($statement->errorInfo());
        }
    }

    public function updateAgenda(Agenda $agenda) {
        // Prepare your SQL statement with placeholders to prevent SQL injection
        $sql = "UPDATE agenda SET artistName = :artistName, eventDay = :eventDay, eventDate = :eventDate, 
                eventTime = :eventTime, durationMinutes = :durationMinutes, ticketPrice = :ticketPrice, 
                ticketsAvailable = :ticketsAvailable, venueAddress = :venueAddress 
                WHERE agendaId = :agendaId";
    
        try {
            // Prepare the SQL statement
            $statement = $this->connection->prepare($sql);
    
            // Bind parameters to the prepared statement
            $statement->bindParam(':agendaId', $agenda->getAgendaId(), PDO::PARAM_INT);
            $statement->bindParam(':artistName', $agenda->getArtistName(), PDO::PARAM_STR);
            $statement->bindParam(':eventDay', $agenda->getEventDay(), PDO::PARAM_STR);
            $statement->bindParam(':eventDate', $agenda->getEventDate(), PDO::PARAM_STR);
            $statement->bindParam(':eventTime', $agenda->getEventTime(), PDO::PARAM_STR);
            $statement->bindParam(':durationMinutes', $agenda->getDurationMinutes(), PDO::PARAM_INT);
            $statement->bindParam(':ticketPrice', $agenda->getTicketPrice(), PDO::PARAM_STR); // Use STR for prices that can have decimals
            $statement->bindParam(':ticketsAvailable', $agenda->getTicketsAvailable(), PDO::PARAM_INT);
            $statement->bindParam(':venueAddress', $agenda->getVenueAddress(), PDO::PARAM_STR);
    
            // Execute the statement and check if it was successful
            $success = $statement->execute();
    
            if ($success && $statement->rowCount() > 0) {
                echo "Agenda information updated successfully.\n";
            } else {
                // If no rows were affected, it could mean the agendaId does not exist or the data is the same as what's in the database
                echo "No rows were affected, possibly because the agenda ID was not found or the data is identical.\n";
            }
        } catch (\PDOException $e) {
            // Log the error or handle it as per your needs
            error_log("SQL Error: " . $e->getMessage());
    
            // Optionally, re-throw the exception if you want calling code to handle it
            throw new \Exception("An error occurred while updating agenda data.");
        }
    }
    
    public function updateTicket(Ticket $ticket){
        // Prepare the SQL statement with placeholders
        $sql = "UPDATE tickets SET artistName = :artistName, sessionTime = :sessionTime, sessionDate = :sessionDate, venue = :venue, ticketPrice = :ticketPrice WHERE ticketId = :ticketId";
    
        // Get values from the ticket object
        $ticketId = $ticket->getTicketId();
        $artistName = $ticket->getArtistName();
        $sessionTime = $ticket->getSessionTime();
        $sessionDate = $ticket->getSessionDate();
        $venue = $ticket->getVenue();
        $ticketPrice = $ticket->getTicketPrice();
    
        // Manually construct a debug SQL string
        $debugSql = "UPDATE tickets SET artistName = '{$artistName}', sessionTime = '{$sessionTime}', sessionDate = '{$sessionDate}', venue = '{$venue}', ticketPrice = '{$ticketPrice}' WHERE ticketId = {$ticketId}";
    
        // Echo the debug SQL string
        echo "Debug SQL: " . $debugSql . "\n";
    
        // Proceed with the actual prepared statement execution
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $statement->bindParam(':artistName', $artistName, PDO::PARAM_STR);
        $statement->bindParam(':sessionTime', $sessionTime, PDO::PARAM_STR);
        $statement->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
        $statement->bindParam(':venue', $venue, PDO::PARAM_STR);
        $statement->bindParam(':ticketPrice', $ticketPrice, PDO::PARAM_INT);
    
        if ($statement->execute()){
            echo "Statement executed successfully.\n";
            if ($statement->rowCount() > 0) {
                echo "Ticket information updated successfully.\n";
            } else {
                echo "No rows were affected, possibly because the ticket ID was not found.\n";
            }
        } else {
            echo "Statement execution failed.\n";
            var_dump($statement->errorInfo());
        }
    }

    ///////////////delete/////////////////////
    public function deleteArtist(Artist $artist){
        try {
            // Use a prepared statement to delete the artist by artistId
            $stmt = $this->connection->prepare("DELETE FROM artist WHERE artistId = :artistId");
            $artistId = $artist->getArtistId();
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
    
            return true; // Return true if deletion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error deleting artist: ' . $e->getMessage());
        }
    }

    public function deleteAgenda(Agenda $agenda){
        try {
            // Use a prepared statement to delete the agenda by agendaId
            $stmt = $this->connection->prepare("DELETE FROM agenda WHERE agendaId = :agendaId");
            $agendaId = $agenda->getAgendaId();
            $stmt->bindParam(':agendaId', $agendaId, PDO::PARAM_INT);
            $stmt->execute();
    
            return true; // Return true if deletion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error deleting agenda: ' . $e->getMessage());
        }
    }
        
    public function deleteTicket(Ticket $ticket){
        try {
            // Use a prepared statement to delete the ticket by ticketId
            $stmt = $this->connection->prepare("DELETE FROM tickets WHERE ticketId = :ticketId");
            $ticketId = $ticket->getTicketId();
            $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->execute();
    
            return true; // Return true if deletion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error deleting ticket: ' . $e->getMessage());
        }
    }


    ///////////////add/////////////////////
    public function addArtist(Artist $artist){
        try {
            // Use a prepared statement to insert the artist into the database
            $stmt = $this->connection->prepare("INSERT INTO artist (artistName, style, participationDate) VALUES (:artistName, :style, :participationDate)");
            $artistName = $artist->getArtistName();
            $style = $artist->getStyle();
            $participationDate = $artist->getParticipationDate();
            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':style', $style, PDO::PARAM_STR);
            $stmt->bindParam(':participationDate', $participationDate, PDO::PARAM_STR);
            $stmt->execute();
    
            return true; // Return true if insertion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error adding artist: ' . $e->getMessage());
        }
    }

    public function addEvent(Agenda $agenda){
        try {
            // Use a prepared statement to insert the agenda into the database
            $stmt = $this->connection->prepare("INSERT INTO agenda (artistName, eventDay, eventDate, eventTime, durationMinutes, ticketPrice, ticketsAvailable, venueAddress) VALUES (:artistName, :eventDay, :eventDate, :eventTime, :durationMinutes, :ticketPrice, :ticketsAvailable, :venueAddress)");
            $artistName = $agenda->getArtistName();
            $eventDay = $agenda->getEventDay();
            $eventDate = $agenda->getEventDate();
            $eventTime = $agenda->getEventTime();
            $durationMinutes = $agenda->getDurationMinutes();
            $ticketPrice = $agenda->getTicketPrice();
            $ticketsAvailable = $agenda->getTicketsAvailable();
            $venueAddress = $agenda->getVenueAddress();
            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':eventDay', $eventDay, PDO::PARAM_STR);
            $stmt->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
            $stmt->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
            $stmt->bindParam(':durationMinutes', $durationMinutes, PDO::PARAM_INT);
            $stmt->bindParam(':ticketPrice', $ticketPrice, PDO::PARAM_STR);
            $stmt->bindParam(':ticketsAvailable', $ticketsAvailable, PDO::PARAM_INT);
            $stmt->bindParam(':venueAddress', $venueAddress, PDO::PARAM_STR);
            $stmt->execute();
    
            return true; // Return true if insertion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error adding event: ' . $e->getMessage());
        }
    }

    public function addTicket(Ticket $ticket){
        try {
            // Use a prepared statement to insert the ticket into the database
            $stmt = $this->connection->prepare("INSERT INTO tickets (artistName, sessionTime, sessionDate, venue, ticketPrice) VALUES (:artistName, :sessionTime, :sessionDate, :venue, :ticketPrice)");
            $artistName = $ticket->getArtistName();
            $sessionTime = $ticket->getSessionTime();
            $sessionDate = $ticket->getSessionDate();
            $venue = $ticket->getVenue();
            $ticketPrice = $ticket->getTicketPrice();
            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':sessionTime', $sessionTime, PDO::PARAM_STR);
            $stmt->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':ticketPrice', $ticketPrice, PDO::PARAM_INT);
            $stmt->execute();
    
            return true; // Return true if insertion is successful
        } catch (\PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \PDOException('Error adding ticket: ' . $e->getMessage());
        }
    }
}


       
    
