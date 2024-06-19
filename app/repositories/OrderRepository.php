<?php

namespace App\Repositories;

use App\Models\Order;
use DateTime;
use Exception;
use PDO;
use PDOException;

class OrderRepository extends Repository
{


    public function getAllOrders()
    {
        $sql = "SELECT id, ticket_name, event_name, paid, total_amount, orderAt  FROM `order`";
        $rows = $this->executeQuery($sql);
        if (!$rows) {
            echo "No orders found.";
            return [];
        }
        return $this->mapToOrderObject($rows);

    }

    protected function executeQuery($sql): false|array
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
        }
    }

    public function mapToOrderObject($rows)
    {
        $orders = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            $ticket_name = $row['ticket_name'];
            $event_name = $row['event_name'];
            $paid = $row['paid'];
            $total_amount = $row['total_amount'];
            $orderedAt = DateTime::createFromFormat('Y-m-d H:i:s', $row['orderAt']); // Create DateTime object
            $order = new Order($id, $ticket_name, $event_name, $paid, $total_amount, $orderedAt);
            $orders[] = $order;
        }
        return $orders;
    }

    public function addOrder($ticketId, $totalAmount): void
    {
        try {
            // Get ticket_name and event_name using getOrderInfo
            $orderInfo = $this->getOrderInfo($ticketId);
            $ticketName = $orderInfo['ticket_name'];
            $eventName = $orderInfo['event_name'];


            // Prepare and execute the insert query
            $sql = "INSERT INTO `order` (ticket_id, ticket_name, event_name, paid, total_amount) VALUES (:ticketId, :ticketName, :eventName, :paid, :totalAmount)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
            $stmt->bindParam(':ticketName', $ticketName, PDO::PARAM_STR);
            $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
            $stmt->bindValue(':paid', false, PDO::PARAM_BOOL);
            $stmt->bindValue(':totalAmount', $totalAmount, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {

            error_log("Error adding order: " . $e->getMessage());
            throw new Exception("Failed to add order");
        }
    }

    public function getOrderInfo($ticketId)
    {
        $sql = "SELECT ut.ticket_id, t.event_name, t.ticket_name
    FROM user_tickets ut
    INNER JOIN ticket t ON ut.ticket_id = t.id
    WHERE ut.ticket_id = :ticket_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; // Return the fetched row
    }

    public function deleteOrder($ticketId): void
    {
        $sql = "DELETE FROM `order` WHERE ticket_id = :ticketId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
    }


}