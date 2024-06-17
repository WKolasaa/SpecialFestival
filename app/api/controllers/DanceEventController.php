<?php

namespace App\Controllers;

use App\Services\DanceEventService;
use App\Services\UserTicketService;
use Exception;
use App\Models\Artist;
use App\Models\DanceOverView;

require_once 'basecontroller.php';

class DanceEventController extends BaseController
{
    private $danceEventService;
    private $userTicketService;

    function __construct()
    {
        $this->danceEventService = new DanceEventService();
        $this->userTicketService = new UserTicketService();
    }

    public function Artists()
    {
        try {
            $this->setHeaders();


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
            $this->setHeaders();

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
            $this->setHeaders();

            $danceEvent = $this->danceEventService->getAllSessions();

            echo json_encode($danceEvent);

        } catch (Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching danceEvent data.']);
        }

    }

    public function danceOverviews()
    {
        try {
            $this->setHeaders();

            $danceEvent = $this->danceEventService->getAllDanceOverviews();
            // var_dump($danceEvent);

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
        // var_dump($sanitizedArtistData);
        // Check if an image file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            // Check the file type
            $fileType = $_FILES['image']['type'];
            if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif' && $fileType != 'image/webp') {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG,WEBP, or GIF image.']);
                return;
            }

            // Check the file size 
            $fileSize = $_FILES['image']['size'];
            if ($fileSize > 10 * 1024 * 1024) {
                http_response_code(400);
                echo json_encode(['error' => 'File is too large. Maximum size .']);
                return;
            }

            $targetDir = "img/DanceEvent/";
            $oldImagePath = $targetDir . $existingArtist->getImageName();
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $sanitizedArtistData['imageName'] = $imageName;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to upload the image.']);
                return;
            }
            // $sanitizedArtistData['imageName'] = $imageName;
        } else {
            $sanitizedArtistData['imageName'] = $existingArtist->getImageName();
        }

        try {

            $this->danceEventService->updateArtist($sanitizedArtistData);
            echo json_encode(['message' => 'Artist information updated successfully']);
        } catch (Exception $e) {
            error_log($e->getMessage());
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

    public function updateDanceOverView()
    {

        header('Content-Type: application/json');

        // Check if request is empty
        if (empty($_POST)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request']);
            return;
        }
        // Sanitize artist data
        $sanitizedDanceOverviewData = $this->sanitizeDanceOverview($_POST);
        $existingOverview = $this->danceEventService->getDanceOverviewById($sanitizedDanceOverviewData['id']);

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
            if ($fileSize > 10 * 1024 * 1024) { // 10MB in bytes
                http_response_code(400);
                echo json_encode(['error' => 'File is too large. Maximum size is 10MB.']);
                return;
            }

            $targetDir = "img/DanceEvent/";
            $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $sanitizedDanceOverviewData['imageName'] = $imageName;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to upload the image.']);
                return;
            }
            $sanitizedDanceOverviewData['imageName'] = $imageName;
        } else {
            $sanitizedDanceOverviewData['imageName'] = $existingOverview->getImageName();
        }

        try {

            $this->danceEventService->updateDanceOverview($sanitizedDanceOverviewData);
            echo json_encode(['message' => 'Artist information updated successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update artist information']);
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
    public function deleteDanceOverview()
    {
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
        // echo json_encode(['error' => 'Error decoding JSON data: ' . json_last_error_msg()]);
        $decodedData = json_decode($jsonData, true);
        // var_dump($decodedData);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            // echo json_encode(['error' => 'Error decoding JSON data']);
            echo json_encode(['error' => 'Error decoding JSON data: ' . json_last_error_msg()]);

            return;
        }
        $id = $decodedData['id'];
        try {

            $artist = $this->danceEventService->getDanceOverviewById($id);
            // Delete the image file if it exists
            unlink('img/DanceEvent/' . $artist->getImageName());

            $this->danceEventService->deleteDanceOverview($id);
            echo json_encode(['message' => 'overview deleted successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete overview']);
        }
    }



    ////////////////add////////////////////////////
    public function addArtist()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            error_log('File upload attempt: ' . print_r($_FILES['image'], true)); // Debugging: Log file upload details

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                // Check the file type
                $fileType = $_FILES['image']['type'];
                if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif' && $fileType != 'image/jpg' && $fileType != 'image/JPG' && $fileType != 'image/PNG' && $fileType != 'image/GIF' && $fileType != 'image/webp') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG, Webp or GIF image.']);
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
            // var_dump($sanitizedSessionData);
            $this->danceEventService->addSession($sanitizedSessionData);
            echo json_encode(['message' => 'session added successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add session']);
        }
    }

    public function addDanceOverview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $header = $_POST['header'];
            $subHeader = $_POST['subHeader'];
            $text = $_POST['text'];
            $imageName = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                // Check the file type
                $fileType = $_FILES['image']['type'];
                if ($fileType != 'image/jpeg' && $fileType != 'image/png' && $fileType != 'image/gif' && $fileType != 'image/jpg' && $fileType != 'image/JPG' && $fileType != 'image/PNG' && $fileType != 'image/GIF') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Please upload a JPEG, PNG, or GIF image.']);
                    return;
                }

                // Check the file size (10MB max)
                $fileSize = $_FILES['image']['size'];
                if ($fileSize > 10 * 1024 * 1024) {
                    http_response_code(400);
                    echo json_encode(['error' => 'File is too large. Maximum size is 10MB.']);
                    return;
                }

                $targetDir = "img/DanceEvent/";
                $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to upload the image.']);
                    return;
                }
            }

            $overview = new DanceOverView(null, $header, $subHeader, $text, $imageName);
            error_log(print_r($overview, true));

            try {
                $this->danceEventService->addDanceOverview($overview);

                echo json_encode(['success' => true, 'message' => 'overview added successfully']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add overview']);

            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }


    //////////////////AddTicket////////////////////////
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
        $sanitizedTicketData = $this->sanitizeSessionData($decodedData);
        try {
            // var_dump($sanitizedTicketData);
            $this->danceEventService->addTicket($sanitizedTicketData);
            $danceTicket = $this->danceEventService->convertSessionToTicket($sanitizedTicketData);

            session_start();
            $userId = $_SESSION['userId'];
            $this->userTicketService->addUserTicket($danceTicket, $userId); ///
            //   echo json_encode(['message' => 'Ticket added successfully']);
        } catch (Exception $e) {
            error_log('Error in ticketService->addTicket: ' . $e->getMessage());
        }

    }

    public function checkUser()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            echo json_encode(['hasSession' => true]);
        } else {
            echo json_encode(['hasSession' => false]);
        }
    }


    private function sanitizeArtistData($artistData) // Use a different name for the parameter to avoid confusion
    {

        $fields = [
            'artistId' => FILTER_SANITIZE_NUMBER_INT,
            'artistName' => FILTER_SANITIZE_SPECIAL_CHARS,
            'style' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'participationDate' => FILTER_SANITIZE_SPECIAL_CHARS,
            'imageName' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        return $this->sanitizeData($artistData, $fields);

        // return $sanitizedData; // Return the sanitized data
    }

    private function sanitizeAgendaData($agendaData)
    {
        $fields = [
            'agendaId' => FILTER_SANITIZE_NUMBER_INT,
            'artistName' => FILTER_SANITIZE_SPECIAL_CHARS,
            'eventDay' => FILTER_SANITIZE_SPECIAL_CHARS,
            'eventDate' => FILTER_SANITIZE_SPECIAL_CHARS,
            'eventTime' => FILTER_SANITIZE_SPECIAL_CHARS,
            'durationMinutes' => FILTER_SANITIZE_SPECIAL_CHARS,
            'sessionPrice' => FILTER_SANITIZE_SPECIAL_CHARS,
            'sessionsAvailable' => FILTER_SANITIZE_SPECIAL_CHARS,
            'venueAddress' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        return $this->sanitizeData($agendaData, $fields);
    }

    private function sanitizeSessionData($sessionData)
    {
        $fields = [
            'sessionId' => FILTER_SANITIZE_NUMBER_INT,
            'sessionType' => FILTER_SANITIZE_SPECIAL_CHARS,
            'artistName' => FILTER_SANITIZE_SPECIAL_CHARS,
            'startSession' => FILTER_SANITIZE_SPECIAL_CHARS,
            'sessionDate' => FILTER_SANITIZE_SPECIAL_CHARS,
            'venue' => FILTER_SANITIZE_SPECIAL_CHARS,
            'sessionPrice' => FILTER_SANITIZE_SPECIAL_CHARS,
            'endSession' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        return $this->sanitizeData($sessionData, $fields);
    }

    private function sanitizeDanceOverview($overview)
    {

        $fields = [
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'header' => FILTER_SANITIZE_SPECIAL_CHARS,
            'subHeader' => FILTER_SANITIZE_SPECIAL_CHARS,
            'text' => FILTER_SANITIZE_SPECIAL_CHARS,
            'imageName' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        return $this->sanitizeData($overview, $fields);
    }

}
