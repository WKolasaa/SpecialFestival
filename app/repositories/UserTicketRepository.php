<?php
namespace App\Repositories;
use App\Models\Ticket;
use PDO;

class UserTicketRepository extends Repository
{
    public function getAllTicketIdsByUserId(int $userId) : array
    {
        $sql = "SELECT ticket_id FROM user_tickets WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        if (!$rows) {
            echo "No tickets found.";
            return [];
        }
        return $rows;
    }

    public function addUserTicket(Ticket $ticket, int $userId): void
    {
        $sql = "INSERT INTO user_tickets (user_id, ticket_id, quantity, paid) VALUES (:userId, :ticketId, :quantity, :paid)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':ticketId', $ticket->id, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', 1, PDO::PARAM_INT);
        $stmt->bindValue(':paid', false, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function addTicketQuantity(Ticket $ticket, int $userId, int $quantity): void
    {
        $sql = "UPDATE user_tickets SET quantity = quantity + :quantity WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':ticketId', $ticket->id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function hasTicket(Ticket $ticket, int $userId): bool
    {
        $sql = "SELECT * FROM user_tickets WHERE user_id = :userId AND ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':ticketId', $ticket->id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return (bool)$row;
    }
}