<?php
namespace App\Repositories;

use App\Models\Ticket;
use PDO;
use PDOException;
use App\Models\QrCode;

class UserTicketRepository extends Repository
{
    public function getAllUserTicketsByUserId(int $userId): array
    {
        $sql = "SELECT ticket_id, quantity, paid FROM user_tickets WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!$rows) {
            echo "No tickets found.";
            return [];
        }
        return $rows;
    }

    public function addUserTicket(Ticket $ticket, int $userId): void
    {
        //echo "ADD USER TICKET REPOSITORY";

        $ticketId = $this->getTicketId($ticket);
        //echo "This is the ticket id: " . $ticketId;

        try {
            $sql = "INSERT INTO user_tickets (user_id, ticket_id, quantity, paid) VALUES (:userId, :ticketId, :quantity, :paid)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->bindValue(':quantity', 1, PDO::PARAM_INT);
            $stmt->bindValue(':paid', false, PDO::PARAM_BOOL);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function addTicketQuantity(Ticket $ticket, int $userId, int $quantity): void
    {
        $sql = "UPDATE user_tickets SET quantity = quantity + :quantity WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $ticket->getTicketId(), PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function hasTicket(Ticket $ticket, int $userId): bool
    {
        $sql = "SELECT * FROM user_tickets WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $ticket->getTicketId(), PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return (bool) $row;
    }

    private function getTicketId(Ticket $ticket)
    {
        $sql = "SELECT id FROM ticket WHERE ticketId = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':ticketId', $ticket->getTicketId(), PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $id = $row['id'];
        return $id;
    }


    public function checkAndGenerateQrForPaidTicket(int $ticketId)
    {
        // Get the ticket from the user_tickets table
        $sql = "SELECT * FROM user_tickets WHERE ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ticket && $ticket['paid'] == 1) {
            // Insert a row into the qr table
            $sql = "INSERT INTO qr (user_ticket_id, scan) VALUES (:userTicketId, :scan)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':userTicketId', $ticketId, PDO::PARAM_INT);
            $stmt->bindValue(':scan', 0, PDO::PARAM_INT); // Set scan to 0 (not scanned)
            $stmt->execute();

        } else {
            // The ticket is not paid or does not exist, return an error
            throw new \Exception("Ticket with id $ticketId does not exist or is not paid");
        }
    }
    

}