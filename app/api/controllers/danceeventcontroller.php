<?php

namespace App\Controllers;

use App\Services\DanceEventService;
use Exception;

class DanceEventController
{
    private $danceEventService;

    function __construct()
    {
        $this->danceEventService = new DanceEventService();
    }

    public function Artists()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $danceEvent = $this->danceEventService->getAllArtists();

            echo json_encode($danceEvent);

        } catch (\Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }
    public function agenda()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $danceEvent = $this->danceEventService->getAllAgendas();

            echo json_encode($danceEvent);

        } catch (\Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }

    public function Tickets()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $danceEvent = $this->danceEventService->getAllTickets();

            echo json_encode($danceEvent);

        } catch (\Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }

    public function updateArtist()
    {
        header('Content-Type: application/json');

        // Check if request body is empty
        $jsonData = file_get_contents('php://input');
        if (empty($jsonData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request body']);
            return;
        }
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedArtistData = $this->sanitizeArtistData($decodedData);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        try {

            $this->danceEventService->updateArtist($sanitizedArtistData);
            echo json_encode(['message' => 'Artist information updated successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update artist information']);
        }

    }
    public function updateAgenda() {
        header('Content-Type: application/json');
        try {
            $jsonData = file_get_contents('php://input');
            if (empty($jsonData)) {
                throw new Exception('Empty request body', 400);
            }
    
            $decodedData = json_decode($jsonData, true);
            if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error decoding JSON data', 400);
            }
    
            $sanitizedAgendaData = $this->sanitizeAgendaData($decodedData);
            $this->danceEventService->updateAgenda($sanitizedAgendaData);
    
            http_response_code(200);
            $response = ['message' => 'Agenda information updated successfully'];
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            $response = ['error' => $e->getMessage()];
        }
    }
    
    public function updateTicket()
    {
        header('Content-Type: application/json');

        // Check if request body is empty
        $jsonData = file_get_contents('php://input');
        if (empty($jsonData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request body']);
            return;
        }
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedTicketData = $this->sanitizeTicketData($decodedData);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        try {
            $this->danceEventService->updateTicket($sanitizedTicketData);
            echo json_encode(['message' => 'Ticket information updated successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update ticket information']);
        }
    }

    ////////////////delete////////////////////////////
    public function deleteArtist(){
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedArtistData = $this->sanitizeArtistData($decodedData);
        try {
            $this->danceEventService->deleteArtist($sanitizedArtistData);
            echo json_encode(['message' => 'Artist deleted successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete artist']);
        }
    }

    public function deleteAgenda(){
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedAgendaData = $this->sanitizeAgendaData($decodedData);
        try {
            $this->danceEventService->deleteAgenda($sanitizedAgendaData);
            echo json_encode(['message' => 'Agenda deleted successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete agenda']);
        }
    }

    public function deleteTicket(){
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedTicketData = $this->sanitizeTicketData($decodedData);
        try {
            $this->danceEventService->deleteTicket($sanitizedTicketData);
            echo json_encode(['message' => 'Ticket deleted successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete ticket']);
        }
    }

    /////////////////add///////////////////////////

    public function addArtist()
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
        $sanitizedArtistData = $this->sanitizeArtistData($decodedData);
        try {
            $this->danceEventService->addArtist($sanitizedArtistData);
            echo json_encode(['message' => 'Artist added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add artist']);
        }
    }

    public function addEvent()
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
        $sanitizedAgendaData = $this->sanitizeAgendaData($decodedData);
        try {
            $this->danceEventService->addEvent($sanitizedAgendaData);
            echo json_encode(['message' => 'Agenda added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add agenda']);
        }
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
            $this->danceEventService->addTicket($sanitizedTicketData);
            echo json_encode(['message' => 'Ticket added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add ticket']);
        }
    }



    private function sanitizeArtistData($artistData) // Use a different name for the parameter to avoid confusion
    {
        $sanitizedData = []; // Initialize a new array for the sanitized data
        // $sanitizedData['artistId'] = filter_var($artistData['artistId'], FILTER_SANITIZE_NUMBER_INT);
        if(isset($artistData['artistId']) && !empty($artistData['artistId'])){
            $sanitizedData['artistId'] = filter_var($artistData['artistId'], FILTER_SANITIZE_NUMBER_INT);
        }
        $sanitizedData['artistName'] = filter_var($artistData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['style'] = filter_var($artistData['style'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['participationDate'] = filter_var($artistData['participationDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData; // Return the sanitized data
    }

    private function sanitizeAgendaData($agendaData)
    {
        $sanitizedData = [];
        // $sanitizedData['agendaId'] = filter_var($agendaData['agendaId'], FILTER_SANITIZE_NUMBER_INT);
        if(isset($agendaData['agendaId']) && !empty($agendaData['agendaId'])){
            $sanitizedData['agendaId'] = filter_var($agendaData['agendaId'], FILTER_SANITIZE_NUMBER_INT);
        }
        $sanitizedData['artistName'] = filter_var($agendaData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventDay'] = filter_var($agendaData['eventDay'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventDate'] = filter_var($agendaData['eventDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventTime'] = filter_var($agendaData['eventTime'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['durationMinutes'] = filter_var($agendaData['durationMinutes'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['ticketPrice'] = filter_var($agendaData['ticketPrice'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['ticketsAvailable'] = filter_var($agendaData['ticketsAvailable'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['venueAddress'] = filter_var($agendaData['venueAddress'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData;
    }

    private function sanitizeTicketData($ticketData)
    {
        $sanitizedData = [];
        if (isset($ticketData['ticketId']) && !empty($ticketData['ticketId'])) {
            $sanitizedData['ticketId'] = filter_var($ticketData['ticketId'], FILTER_SANITIZE_NUMBER_INT);
        }

       // $sanitizedData['ticketId'] = filter_var($ticketData['ticketId'], FILTER_SANITIZE_NUMBER_INT);
        $sanitizedData['artistName'] = filter_var($ticketData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['sessionTime'] = filter_var($ticketData['sessionTime'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['sessionDate'] = filter_var($ticketData['sessionDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['venue'] = filter_var($ticketData['venue'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['ticketPrice'] = filter_var($ticketData['ticketPrice'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData;
    }


}
