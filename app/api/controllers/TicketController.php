<?php

namespace App\Controllers;

use App\Services\TicketService;
use Exception;

class TicketController
{

    private $ticketService;

    function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function addTicket()
    {
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        if (empty($jsonData)) {
            http_response_code(400);
            echo json_encode(['error' => 'Empty request body']);
            return;
        }
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedTicketData = $this->sanitizeTicketData($decodedData);
        try {
            $this->ticketService->addTicket($sanitizedTicketData);
            echo json_encode(['message' => 'Ticket added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add ticket']);
        }

    }


    private function sanitizeTicketData(array $ticketData): array
    {
        $sanitizedData = [];
        $sanitizedData['event_name'] = filter_var($ticketData['event_name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['ticket_Type'] = filter_var($ticketData['ticket_Type'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['ticket_name'] = filter_var($ticketData['ticket_name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['location'] = filter_var($ticketData['location'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['description'] = filter_var($ticketData['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['price'] = filter_var($ticketData['price'], FILTER_SANITIZE_NUMBER_INT);
        $sanitizedData['start_date'] = filter_var($ticketData['start_date'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['end_date'] = filter_var($ticketData['end_date'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData;
    }


}