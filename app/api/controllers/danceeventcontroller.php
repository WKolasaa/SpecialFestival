<?php

namespace App\Controllers;

use App\Services\DanceEventService;
use Exception;
use App\Models\Artist;

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

        } catch (Exception $e) {
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

        } catch (Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }

    public function sessions()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET, POST Delete, OPTIONS");
            header("Content-Type: application/json");

            $danceEvent = $this->danceEventService->getAllSessions();

            echo json_encode($danceEvent);

        } catch (Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }
    public function updateArtist()
    {
        header('Content-Type: application/json');

        // Check if request is empty
        if (empty($_POST)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request']);
            return;
        }
        // Sanitize artist data
        $sanitizedArtistData = $this->sanitizeArtistData($_POST);
        $existingArtist = $this->danceEventService->getArtistById($sanitizedArtistData['artistId']);

        // Check if an image file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            // Check the file type
            $fileType = $_FILES['image']['type'];
            if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif') {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG, or GIF image.']);
                return;
            }

            // Check the file size (5MB max)
            $fileSize = $_FILES['image']['size'];
            if ($fileSize > 10 * 1024 * 1024) { // 5MB in bytes
                http_response_code(400);
                echo json_encode(['error' => 'File is too large. Maximum size is 5MB.']);
                return;
            }

            $targetDir = "img/DanceEvent/";
            $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $sanitizedArtistData['imageName'] = $imageName;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to upload the image.']);
                return;
            }
            $sanitizedArtistData['imageName'] = $imageName;
        } else {
            $sanitizedArtistData['imageName'] = $existingArtist->getImageName();
        }

        try {

            $this->danceEventService->updateArtist($sanitizedArtistData);
            echo json_encode(['message' => 'Artist information updated successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update artist information']);
        }
    }




    public function updateAgenda()
    {
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

    public function updateSession()
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
        $sanitizedSessionData = $this->sanitizeSessionData($decodedData);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        try {
            $this->danceEventService->updateSession($sanitizedSessionData);
            echo json_encode(['message' => 'session information updated successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update session information']);
        }
    }

    ////////////////delete////////////////////////////
    public function deleteArtist()
    {
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $artistId = $decodedData['artistId'];
        try {
            $artist = $this->danceEventService->getArtistById($artistId);
            // Delete the image file if it exists
            unlink('img/DanceEvent/' . $artist->getImageName());

            $this->danceEventService->deleteArtist($artistId);
            echo json_encode(['message' => 'Artist deleted successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete artist']);
        }
    }

    public function deleteAgenda()
    {
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
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete agenda']);
        }
    }

    public function deleteSession()
    {
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }
        $sanitizedSessionData = $this->sanitizeSessionData($decodedData);
        try {
            $this->danceEventService->deleteSession($sanitizedSessionData);
            echo json_encode(['message' => 'session deleted successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete session']);
        }
    }

    ////////////////add////////////////////////////
    public function addArtist()
    {
        error_log("addArtist endpoint hit"); // Debugging: Log endpoint hit

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            error_log('File upload attempt: ' . print_r($_FILES['image'], true)); // Debugging: Log file upload details

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                // Check the file type
                $fileType = $_FILES['image']['type'];
                if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif' && $fileType != 'image/jpg' && $fileType != 'image/JPG' && $fileType != 'image/PNG' && $fileType != 'image/GIF') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG, or GIF image.']);
                    return;
                }

                $fileSize = $_FILES['image']['size'];
                if ($fileSize > 10 * 1024 * 1024) {
                    http_response_code(400);
                    echo json_encode(['error' => 'File is too large. Maximum size is 10MB.']);
                    return;
                }

                $targetDir = "img/DanceEvent/";
                $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $imageName;


                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $artistName = $_POST['artistName'];
                    $style = $_POST['style'];
                    $description = $_POST['description'];
                    $title = $_POST['title'];
                    $participationDate = $_POST['participationDate'];

                    $artist = new Artist(null, $artistName, $style, $description, $title, $participationDate, $imageName);

                    // Assuming $this->danceEventService is initialized correctly
                    try {
                        $this->danceEventService->addArtist($artist);
                        echo json_encode(['success' => true, 'message' => 'Artist added successfully']);
                        error_log("Artist added successfully"); // Debugging: Log success
                    } catch (Exception $e) {
                        // Handle any exceptions during the database operation
                        http_response_code(500);
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to upload the image.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Image not uploaded']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
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

    public function addSession()
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
        try {
            $sanitizedSessionData = $this->sanitizeSessionData($decodedData);
            $this->danceEventService->addSession($sanitizedSessionData);
            echo json_encode(['message' => 'session added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add session']);
        }
    }



    private function sanitizeArtistData($artistData) // Use a different name for the parameter to avoid confusion
    {
        $sanitizedData = [];
        if (isset($artistData['artistId']) && !empty($artistData['artistId'])) {
            $sanitizedData['artistId'] = filter_var($artistData['artistId'], FILTER_SANITIZE_NUMBER_INT);
        }
        $sanitizedData['artistName'] = filter_var($artistData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['style'] = filter_var($artistData['style'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['description'] = filter_var($artistData['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['title'] = filter_var($artistData['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['participationDate'] = filter_var($artistData['participationDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($artistData['imageName']) && !empty($artistData['imageName'])) {

            $sanitizedData['imageName'] = filter_var($artistData['imageName'], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $sanitizedData['imageName'] = '';
        }

        return $sanitizedData; // Return the sanitized data
    }

    private function sanitizeAgendaData($agendaData)
    {
        $sanitizedData = [];
        // $sanitizedData['agendaId'] = filter_var($agendaData['agendaId'], FILTER_SANITIZE_NUMBER_INT);
        if (isset($agendaData['agendaId']) && !empty($agendaData['agendaId'])) {
            $sanitizedData['agendaId'] = filter_var($agendaData['agendaId'], FILTER_SANITIZE_NUMBER_INT);
        }
        $sanitizedData['artistName'] = filter_var($agendaData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventDay'] = filter_var($agendaData['eventDay'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventDate'] = filter_var($agendaData['eventDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['eventTime'] = filter_var($agendaData['eventTime'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['durationMinutes'] = filter_var($agendaData['durationMinutes'], FILTER_SANITIZE_SPECIAL_CHARS);
        // ticket means session
        $sanitizedData['sessionPrice'] = filter_var($agendaData['sessionPrice'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['sessionsAvailable'] = filter_var($agendaData['sessionsAvailable'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['venueAddress'] = filter_var($agendaData['venueAddress'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData;
    }

    private function sanitizeSessionData($sessionData)
    {
        // var_dump($sessionData);
        $sanitizedData = [];
        if (isset($sessionData['sessionId']) && !empty($sessionData['sessionId'])) {
            $sanitizedData['sessionId'] = filter_var($sessionData['sessionId'], FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($sessionData['sessionType']) && !empty($sessionData['sessionType'])) {
            $sanitizedData['sessionType'] = filter_var($sessionData['sessionType'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $sanitizedData['artistName'] = filter_var($sessionData['artistName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['startSession'] = filter_var($sessionData['startSession'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['sessionDate'] = filter_var($sessionData['sessionDate'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['venue'] = filter_var($sessionData['venue'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['sessionPrice'] = filter_var($sessionData['sessionPrice'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedData['endSession'] = filter_var($sessionData['endSession'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitizedData;
    }
}
