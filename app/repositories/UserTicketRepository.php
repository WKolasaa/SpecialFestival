<?php

namespace App\Repositories;

use App\Models\Ticket;
use Exception;
use PDO;

class UserTicketRepository extends Repository
{
    public function getAllUserTicketsByUserId(int $userId, bool $paid): array
    {
        if ($paid) {
            $sql = "SELECT ticket_id, quantity, paid FROM user_tickets WHERE user_id = :userId";
        } else {
            $sql = "SELECT ticket_id, quantity, paid FROM user_tickets WHERE user_id = :userId AND paid = :paid";
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if (!$paid) {
            $stmt->bindParam(':paid', $paid, PDO::PARAM_BOOL);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addUserTicket(Ticket $ticket, int $userId): void
    {
        $userTicketId = $this->getTicketId($ticket);
        //echo $userTicketId;


        $sql = "INSERT INTO user_tickets (user_id, ticket_id, quantity, paid) VALUES (:userId, :ticketId, :quantity, :paid)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $userTicketId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', 1, PDO::PARAM_INT);
        $stmt->bindValue(':paid', false, PDO::PARAM_BOOL);

        $stmt->execute();

    }

    private function getTicketId(Ticket $ticket)
    {
        $sql = "SELECT id FROM ticket WHERE ticketId = :ticketId AND event_name = :eventName AND ticket_name = :ticketName AND price = :price ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':ticketId', $ticket->getTicketId(), PDO::PARAM_INT);
        $stmt->bindValue(':eventName', $ticket->getEventName(), PDO::PARAM_STR);
        $stmt->bindValue(':ticketName', $ticket->getTicketName(), PDO::PARAM_STR);
        $stmt->bindValue(':price', $ticket->getPrice(), PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch();
        $id = $row['id'];
        return $id;
    }

    public function addTicketQuantity(int $ticketId, int $userId, int $quantity): void
    {
        $sql = "UPDATE user_tickets SET quantity = quantity + :quantity WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function hasTicket(Ticket $ticket, int $userId): bool
    {
        $sql = "SELECT * FROM user_tickets WHERE user_id = :userId AND ticket_id = :ticketId"; //TODO: remove the * to avoid sql injection
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $ticket->getTicketId(), PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return (bool)$row;
    }

    public function markTicketsAsPaid(int $userId, array $userTickets): void
    {
        foreach ($userTickets as $userTicket) {
            $sql = "UPDATE user_tickets SET paid = 1 WHERE user_id = :userId AND ticket_id = :ticketId";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':ticketId', $userTicket->ticket->getTicketId(), PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function deleteTicket(int $ticketId, int $userId): void
    {
        $sql = "DELETE FROM user_tickets WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteQrCode(int $ticketId): void
    {
        $sql = "DELETE FROM qr WHERE user_ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function generateShareToken(int $userId): string
    {
        $token = substr(bin2hex(random_bytes(3)), 0, 5);
        $sql = "INSERT INTO share_personal_program (user_id, share_token) VALUES (:userId, :token)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $token;
    }

    public function getShareTokenByUserId(int $userId): ?string
    {
        $sql = "SELECT share_token FROM share_personal_program WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUserIdByShareToken(string $token): ?int
    {
        $sql = "SELECT user_id FROM share_personal_program WHERE share_token = :token";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
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
            throw new Exception("Ticket with id $ticketId does not exist or is not paid");
        }
    }

    public function getTicketByUserID($userID)
    {
        $sql = "SELECT * FROM user_tickets WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }


}