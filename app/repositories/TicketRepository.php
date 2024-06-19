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
        $sql = "SELECT id, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date, available FROM ticket WHERE id = :id";
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
                new DateTime($row['end_date']),
                $row['available']
            );
        } catch (Exception $e) {
            echo "Error creating ticket: " . $e->getMessage();
            return null;
        }
    }

    public function updateTicketAvailability(int $ticketId, int $amount)
    {
        $sql = "UPDATE ticket SET available = available + :amount WHERE id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllTickets()
    {
        $sql = "SELECT id, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date, available FROM ticket";
        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No tickets found.";
            return [];
        }
        return $this->rowToTickets($rows);
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
            $stmt = $this->connection->prepare("INSERT INTO ticket (ticketId, event_name, ticket_Type, ticket_name, location, description, price, start_date, end_date, available) VALUES (:ticketId, :event_name, :ticket_Type, :ticket_name, :location, :description, :price, :start_date, :end_date, :available)");
            //TODO: we should use getter and setter methods to get the values of the ticket object
            $ticketId = $ticket->getTicketId();
            $event_name = $ticket->getEventName();
            $ticket_Type = $ticket->getTicketType()->value;
            $ticket_name = $ticket->getTicketName();
            $location = $ticket->getLocation();
            $description = $ticket->getDescription();
            $price = $ticket->getPrice();
            $start_date = $ticket->getStartDate()->format('Y-m-d H:i:s');
            $end_date = $ticket->getEndDate()->format('Y-m-d H:i:s');
            $available = $ticket->getAvailability();

            $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
            $stmt->bindParam(':ticket_Type', $ticket_Type, PDO::PARAM_INT);
            $stmt->bindParam(':ticket_name', $ticket_name, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
            $stmt->bindParam(':available', $available, PDO::PARAM_INT);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            throw new PDOException('Error adding ticket: ' . $e->getMessage());
        }

    }

    public function deleteTicket(int $ticketId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM ticket WHERE id = :ticketId");
            $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error deleting ticket: ' . $e->getMessage());
        }
    }

    public function addQRCodeTicket(int $userTicketID, string $hash)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO qr (user_ticket_id, code, scan) VALUES (:user_ticket_id, :code, :scanned)");
            $stmt->bindParam(':user_ticket_id', $userTicketID, PDO::PARAM_INT);
            $scanned = 0;
            $stmt->bindParam(':scanned', $scanned, PDO::PARAM_INT);
            $stmt->bindParam(':code', $hash, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error adding qr code ticket: ' . $e->getMessage());
        }
    }

    public function scanQRCode(int $userTicketID)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE qr SET scan = 1 WHERE user_ticket_id = :user_ticket_id");
            $stmt->bindParam(':user_ticket_id', $userTicketID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error scanning qr code: ' . $e->getMessage());
        }
    }

    public function qrCodeScanned(int $userTicketID)
    {
        try {
            $sql = "SELECT scan FROM qr WHERE user_ticket_id = :scanId";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':scanId', $userTicketID, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['scan'] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new PDOException('Error scanning qr code: ' . $e->getMessage());
        }
    }

    public function getQrCode(int $userTicketID)
    {
        try {
            $sql = "SELECT code FROM qr WHERE user_ticket_id = :user_ticket_id";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':user_ticket_id', $userTicketID, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['code'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new PDOException('Error getting qr code: ' . $e->getMessage());
        }
    }

    public function getQRIDByCode($code)
    {
        try {
            $sql = "SELECT user_ticket_id FROM qr WHERE code = :code";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':code', $code, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['user_ticket_id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new PDOException('Error getting qr code: ' . $e->getMessage());
        }
    }
}

