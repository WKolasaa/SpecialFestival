<?php

namespace App\Controllers;

use App\Services\UserTicketService;
use Exception;

class FestPlanController
{
    private UserTicketService $userTicketService;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
    }

    public function increaseTicketQuantity()
    {
        header("Content-Type: application/json");
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);

        $ticketId = $decodedData['ticketId'];
        $userId = $decodedData['userId'];

        try {
            $this->userTicketService->increaseTicketQuantity($ticketId, $userId);
            echo json_encode(['success' => 'Ticket quantity increased']);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function decreaseTicketQuantity()
    {
        header("Content-Type: application/json");
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);

        $ticketId = $decodedData['ticketId'];
        $userId = $decodedData['userId'];

        try {
            $this->userTicketService->decreaseTicketQuantity($ticketId, $userId);
            echo json_encode(['success' => 'Ticket quantity decreased']);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteTicket()
    {
        header("Content-Type: application/json");
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);

        $ticketId = $decodedData['ticketId'];
        $userId = $decodedData['userId'];

        try {
            $this->userTicketService->deleteTicket($ticketId, $userId);
            echo json_encode(['success' => 'Ticket deleted']);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function generateShareToken()
    {
        header("Content-Type: application/json");
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);

        $userId = $decodedData['userId'];

        try {
            $token = $this->userTicketService->generateShareToken($userId);
            echo json_encode(['token' => $token]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}