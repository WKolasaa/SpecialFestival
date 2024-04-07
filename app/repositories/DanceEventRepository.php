<?php

namespace App\Repositories;

use App\Models\Agenda;
use App\Models\Artist;
use App\Models\DanceOverview;
use App\Models\Session;
use Exception;
use PDO;
use PDOException;

class DanceEventRepository extends Repository
{
    public function getAllArtists()
    {
        $sql = "SELECT artistId, artistName, style,description,title, participationDate,imageName FROM artist";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No artists found.";
            return [];
        }
        return $this->mapToArtistObjects($rows);
    }

    protected function executeQuery($sql)
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
        }
    }

    private function mapToArtistObjects($rows)
    {
        $artists = [];
        foreach ($rows as $row) {

            $artistId = $row['artistId'];
            $artistName = $row['artistName'];
            $style = $row['style'];
            $description = $row['description'];
            $title = $row['title'];
            $participationDate = $row['participationDate'];
            $imageName = $row['imageName'];
            $artist = new Artist($artistId, $artistName, $style, $description, $title, $participationDate, $imageName);
            $artists[] = $artist;
        }
        return $artists;
    }

    public function getAllAgendas()
    {
        $sql = "SELECT agendaId, artistName, eventDay, eventDate, eventTime, durationMinutes, sessionPrice, sessionsAvailable, venueAddress FROM agenda";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No agendas found.";
            return [];
        }
        return $this->mapToAgendaObjects($rows);
    }

    private function mapToAgendaObjects($rows)
    {

        $agendas = [];
        foreach ($rows as $row) {
            $agendaId = $row['agendaId'];
            $artistName = $row['artistName'];
            $eventDay = $row['eventDay'];
            $eventDate = $row['eventDate'];
            $eventTime = $row['eventTime'];
            $durationMinutes = $row['durationMinutes'];
            $sessionPrice = $row['sessionPrice'];
            $sessionsAvailable = $row['sessionsAvailable'];
            $venueAddress = $row['venueAddress'];
            $agenda = new Agenda($agendaId, $artistName, $eventDay, $eventDate, $eventTime, $durationMinutes, $sessionPrice, $sessionsAvailable, $venueAddress);
            $agendas[] = $agenda;
        }
        return $agendas;
    }

    public function getAllSessions()
    {
        $sql = "SELECT sessionId, artistName, startSession, sessionDate, venue, sessionPrice, sessionType, endSession FROM session";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No sessions found.";
            return [];
        }
        return $this->mapToSessionObjects($rows);
    }

    private function mapToSessionObjects($rows)
    {
        $sessions = [];
        foreach ($rows as $row) {
            $sessionId = $row['sessionId'];
            $artistName = $row['artistName'];
            $startSession = $row['startSession'];
            $sessionDate = $row['sessionDate'];
            $venue = $row['venue'];
            $sessionPrice = $row['sessionPrice'];
            $sessionType = $row['sessionType'];
            $endSession = $row['endSession'];
            $session = new Session($sessionId, $artistName, $startSession, $sessionDate, $venue, $sessionPrice, $sessionType, $endSession);
            $sessions[] = $session;
        }
        return $sessions;
    }

    public function getAllDanceOverViews()
    {
        $sql = "SELECT id,header,subHeader, text, imageName FROM danceOverview";

        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No dance overviews found.";
            return [];
        }

        return $this->mapToDanceOverViewObjects($rows);
    }

    private function mapToDanceOverViewObjects($rows)
    {
        $danceOverViews = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            $header = $row['header'];
            $subHeader = $row['subHeader'];
            $text = $row['text'];
            $imageName = $row['imageName'];
            $danceOverView = new DanceOverview($id, $header, $subHeader, $text, $imageName);
            $danceOverViews[] = $danceOverView;
        }
        return $danceOverViews;
    }

///////////////////////////update///////////////////////////

    public function updateArtist(Artist $artist)
    {

        try {
            $sql = "UPDATE artist SET artistName = :artistName, style = :style, description= :description, title= :title, participationDate = :participationDate, imageName= :imageName WHERE artistId = :artistId";

            // Get values from the artist object
            $artistId = $artist->getArtistId();
            $artistName = $artist->getArtistName();
            $style = $artist->getStyle();
            $description = $artist->getDescription();
            $title = $artist->getTitle();
            $participationDate = $artist->getParticipationDate();
            $imageName = $artist->getImageName();
            // Manually construct a debug SQL string
            // $debugSql = "UPDATE artist SET artistName = '{$artistName}', style = '{$style}', description= '{$description}' participationDate = '{$participationDate}' WHERE artistId = {$artistId}";
            // echo "Debug SQL: " . $debugSql . "\n";
            // Proceed with the actual prepared statement execution
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $statement->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $statement->bindParam(':style', $style, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':participationDate', $participationDate, PDO::PARAM_STR);
            $statement->bindParam(':imageName', $imageName, PDO::PARAM_STR);

            $statement->execute();


        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error updating artist: ' . $e->getMessage());
        }

    }

    public function updateAgenda(Agenda $agenda)
    {
        // Prepare your SQL statement with placeholders to prevent SQL injection
        $sql = "UPDATE agenda SET artistName = :artistName, eventDay = :eventDay, eventDate = :eventDate, 
                eventTime = :eventTime, durationMinutes = :durationMinutes, sessionPrice = :sessionPrice, 
                sessionsAvailable = :sessionsAvailable, venueAddress = :venueAddress 
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
            $statement->bindParam(':sessionPrice', $agenda->getSessionPrice(), PDO::PARAM_STR); // Use STR for prices that can have decimals
            $statement->bindParam(':sessionsAvailable', $agenda->getSessionsAvailable(), PDO::PARAM_INT);
            $statement->bindParam(':venueAddress', $agenda->getVenueAddress(), PDO::PARAM_STR);

            // Execute the statement and check if it was successful
            $success = $statement->execute();

            if ($success && $statement->rowCount() > 0) {
                echo "Agenda information updated successfully.\n";
            } else {
                // If no rows were affected, it could mean the agendaId does not exist or the data is the same as what's in the database
                echo "No rows were affected, possibly because the agenda ID was not found or the data is identical.\n";
            }
        } catch (PDOException $e) {
            // Log the error or handle it as per your needs
            error_log("SQL Error: " . $e->getMessage());

            // Optionally, re-throw the exception if you want calling code to handle it
            throw new Exception("An error occurred while updating agenda data.");
        }
    }

    public function updateSession(Session $session)
    {

        $sql = "UPDATE session SET artistName = :artistName, startSession = :startSession, sessionDate = :sessionDate, venue = :venue, sessionPrice = :sessionPrice, sessionType= :sessionType, endSession= :endSession WHERE sessionId = :sessionId";

        $sessionId = $session->getSessionId();
        $artistName = $session->getArtistName();
        $startSession = $session->getStartSession();
        $sessionDate = $session->getSessionDate();
        $venue = $session->getVenue();
        $sessionPrice = $session->getSessionPrice();
        $sessionType = $session->getSessionType();
        $endSession = $session->getEndSession();

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $statement->bindParam(':artistName', $artistName, PDO::PARAM_STR);
        $statement->bindParam(':startSession', $startSession, PDO::PARAM_STR);
        $statement->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
        $statement->bindParam(':venue', $venue, PDO::PARAM_STR);
        $statement->bindParam(':sessionPrice', $sessionPrice, PDO::PARAM_STR);
        $statement->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
        $statement->bindParam(':endSession', $endSession, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo "Statement executed successfully.\n";
            if ($statement->rowCount() > 0) {
                echo "session information updated successfully.\n";
            } else {
                echo "No rows were affected, possibly because the session ID was not found.\n";
            }
        } else {
            echo "Statement execution failed.\n";
            var_dump($statement->errorInfo());
        }
    }

    public function updateDanceOverView(DanceOverview $danceOverView)
    {
        $sql = "UPDATE danceOverview SET text = :text, header=:header, subHeader=:subHeader, imageName = :imageName WHERE id = :id";

        $id = $danceOverView->getId();
        $header = $danceOverView->getHeader();
        $subHeader = $danceOverView->getSubHeader();
        $text = $danceOverView->getText();
        $imageName = $danceOverView->getImageName();


        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':header', $header, PDO::PARAM_STR);
        $statement->bindParam(':subHeader', $subHeader, PDO::PARAM_STR);
        $statement->bindParam(':text', $text, PDO::PARAM_STR);
        $statement->bindParam(':imageName', $imageName, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo "Statement executed successfully.\n";
            if ($statement->rowCount() > 0) {
                echo "DanceOverview information updated successfully.\n";
            } else {
                echo "No rows were affected, possibly because the danceOverview ID was not found.\n";
            }
        } else {
            echo "Statement execution failed.\n";
            var_dump($statement->errorInfo());
        }
    }

    ///////////////delete/////////////////////
    public function deleteArtist($artistId)
    {
        try {
            // Use a prepared statement to delete the artist by artistId
            $stmt = $this->connection->prepare("DELETE FROM artist WHERE artistId = :artistId");
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Artist information deleted successfully.\n";
                return true; // Return true if deletion is successful
            } else {
                echo "No rows were affected, possibly because the artist ID was not found.\n";
                return false; // Return false if no rows were affected
            }
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error deleting artist: ' . $e->getMessage());
        }
    }

    public function getArtistById($artistId)
    {
        $sql = "SELECT artistId, artistName, style,description,title, participationDate, imageName FROM artist WHERE artistId = :artistId";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $artist = new Artist($row['artistId'], $row['artistName'], $row['style'], $row['description'], $row['title'], $row['participationDate'], $row['imageName']);
        if (!$row) {
            echo "No artist found with the given ID.\n";
            return null;
        }
        return $artist;
    }

    public function getDanceOverviewById($id)
    {
        $sql = "SELECT id,header,subHeader, text, imageName FROM danceOverview WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $danceOverView = new DanceOverview($row['id'], $row['header'], $row['subHeader'], $row['text'], $row['imageName']);
        if (!$row) {
            echo "No dance overview found with the given ID.\n";
            return null;
        }
        return $danceOverView;
    }

    public function deleteAgenda(Agenda $agenda)
    {
        try {
            // Use a prepared statement to delete the agenda by agendaId
            $stmt = $this->connection->prepare("DELETE FROM agenda WHERE agendaId = :agendaId");
            $agendaId = $agenda->getAgendaId();
            $stmt->bindParam(':agendaId', $agendaId, PDO::PARAM_INT);
            $stmt->execute();

            return true; // Return true if deletion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error deleting agenda: ' . $e->getMessage());
        }
    }

    public function deleteSession(Session $session)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM session WHERE sessionId = :sessionId");
            $sessionId = $session->getSessionId();
            $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
            $stmt->execute();

            return true; // Return true if deletion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error deleting session: ' . $e->getMessage());
        }
    }

    public function deleteDanceOverview($danceOverviewId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM danceOverview WHERE id = :id");
            $id = $danceOverviewId;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // echo "DanceOverview information deleted successfully.\n";
            return true; // Return true if deletion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error deleting danceOverview: ' . $e->getMessage());
        }
    }

    ///////////////add/////////////////////
    public function addArtist(Artist $artist)
    {
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
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error adding artist: ' . $e->getMessage());
        }
    }

    public function addEvent(Agenda $agenda)
    {
        try {
            // Use a prepared statement to insert the agenda into the database
            $stmt = $this->connection->prepare("INSERT INTO agenda (artistName, eventDay, eventDate, eventTime, durationMinutes, sessionPrice, sessionsAvailable, venueAddress) VALUES (:artistName, :eventDay, :eventDate, :eventTime, :durationMinutes, :sessionPrice, :sessionsAvailable, :venueAddress)");
            $artistName = $agenda->getArtistName();
            $eventDay = $agenda->getEventDay();
            $eventDate = $agenda->getEventDate();
            $eventTime = $agenda->getEventTime();
            $durationMinutes = $agenda->getDurationMinutes();
            $sessionPrice = $agenda->getSessionPrice();
            $sessionsAvailable = $agenda->getSessionsAvailable();
            $venueAddress = $agenda->getVenueAddress();
            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':eventDay', $eventDay, PDO::PARAM_STR);
            $stmt->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
            $stmt->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
            $stmt->bindParam(':durationMinutes', $durationMinutes, PDO::PARAM_INT);
            $stmt->bindParam(':sessionPrice', $sessionPrice, PDO::PARAM_STR);
            $stmt->bindParam(':sessionsAvailable', $sessionsAvailable, PDO::PARAM_INT);
            $stmt->bindParam(':venueAddress', $venueAddress, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error adding event: ' . $e->getMessage());
        }
    }

    // public function addSession(Session $session){
    //     try {

    //         $stmt = $this->connection->prepare("INSERT INTO session (artistName, startSession, sessionDate, venue, sessionPrice, sessionType, endSession) VALUES (:artistName, :startSession, :sessionDate, :venue, :sessionPrice, :sessionType, :endSession)");
    //         $artistName = $session->getArtistName();
    //         $startSession = $session->getStartSession();
    //         $sessionDate = $session->getSessionDate();
    //         $venue = $session->getVenue();
    //         $sessionPrice = $session->getSessionPrice();
    //         $sessionType = $session->getSessionType();
    //         $endSession = $session->getEndSession();
    //         $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
    //         // $stmt->bindParam(':startSession', $startSession, PDO::PARAM_STR);
    //         if ($startSession !== NULL) {
    //             $stmt->bindParam(':startSession', $startSession, PDO::PARAM_STR);
    //         }

    //         $stmt->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
    //         $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
    //         $stmt->bindParam(':sessionPrice', $sessionPrice, PDO::PARAM_STR);
    //         $stmt->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
    //         // $stmt->bindParam(':endSession', $endSession, PDO::PARAM_STR);
    //         if ($endSession !== NULL) {
    //             $stmt->bindParam(':endSession', $endSession, PDO::PARAM_STR);
    //         }
    //         $stmt->execute();

    //         return true; // Return true if insertion is successful
    //     } catch (\PDOException $e) {
    //         // Handle the exception (log, show an error message, etc.)
    //         throw new \PDOException('Error adding session: ' . $e->getMessage());
    //     }
    // }
    public function addSession(Session $session)
    {
        try {
            $artistName = $session->getArtistName();
            $startSession = $session->getStartSession();
            $sessionDate = $session->getSessionDate();
            $venue = $session->getVenue();
            $sessionPrice = $session->getSessionPrice();
            $sessionType = $session->getSessionType();
            $endSession = $session->getEndSession();

            $sql = "INSERT INTO session (artistName, sessionDate, venue, sessionPrice, sessionType";
            if ($startSession !== NULL) { // Check if the startSession is set because of the all day access sessions
                $sql .= ", startSession";
            }
            if ($endSession !== NULL) {// Check if the startSession is set because of the all day access sessions
                $sql .= ", endSession";
            }
            $sql .= ") VALUES (:artistName, :sessionDate, :venue, :sessionPrice, :sessionType";
            if ($startSession !== NULL) {
                $sql .= ", :startSession";
            }
            if ($endSession !== NULL) {
                $sql .= ", :endSession";
            }
            $sql .= ")";

            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':sessionPrice', $sessionPrice, PDO::PARAM_STR);
            $stmt->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
            if ($startSession !== NULL) {
                $stmt->bindParam(':startSession', $startSession, PDO::PARAM_STR);
            }
            if ($endSession !== NULL) {
                $stmt->bindParam(':endSession', $endSession, PDO::PARAM_STR);
            }

            $stmt->execute();

            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error adding session: ' . $e->getMessage());
        }
    }

    public function addDanceOverView(DanceOverview $danceOverView)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO danceOverview (header,subHeader,text, imageName) VALUES (:header, :subHeader, :text, :imageName)");
            $header = $danceOverView->getHeader();
            $subHeader = $danceOverView->getSubHeader();
            $text = $danceOverView->getText();
            $imageName = $danceOverView->getImageName();
            $stmt->bindParam(':header', $header, PDO::PARAM_STR);
            $stmt->bindParam(':subHeader', $subHeader, PDO::PARAM_STR);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error adding danceOverview: ' . $e->getMessage());
        }
    }

    public function addTicket(Session $session)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO session (artistName, startSession, sessionDate, venue, sessionPrice, sessionType, endSession) VALUES (:artistName, :startSession, :sessionDate, :venue, :sessionPrice, :sessionType, :endSession)");
            $artistName = $session->getArtistName();
            $startSession = $session->getStartSession();
            $sessionDate = $session->getSessionDate();
            $venue = $session->getVenue();
            $sessionPrice = $session->getSessionPrice();
            $sessionType = $session->getSessionType();
            $endSession = $session->getEndSession();
            $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
            $stmt->bindParam(':startSession', $startSession, PDO::PARAM_STR);
            $stmt->bindParam(':sessionDate', $sessionDate, PDO::PARAM_STR);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':sessionPrice', $sessionPrice, PDO::PARAM_STR);
            $stmt->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
            $stmt->bindParam(':endSession', $endSession, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error adding session: ' . $e->getMessage());
        }
    }
}


       
    
