<?php

namespace App\Controllers;

use App\Models\HistoryTicket;
use App\Services\CartService;
use App\Services\HistoryAdminService;
use App\Services\UserTicketService;
use Exception;

class HistoryAdminController
{
    private $historyAdminService;
    private $userTicketService;

    function __construct()
    {
        $this->userTicketService = new UserTicketService();
        $this->historyAdminService = new HistoryAdminService();
    }

    //////////////////////////////// Update of text entry ////////////////////////////////
    public function update()
    {
        $entry_id = $_POST["entry_id"];
        $content = $_POST["content"];

        // Call to service layer to update the entry in the database
        $this->historyAdminService->updateEntry($entry_id, $content);

        header('Content-Type: application/json');

        echo json_encode(['success' => true, 'message' => 'Content updated successfully.']);

        exit();
    }

    //////////////////////////////// Update of image entry ////////////////////////////////
    // Handles file upload and updates the entry with the new image path.
    public function updateImage()
    {
        $entry_id = $_POST["entry_id"];

        // Get the current image path to delete it
        $oldImagePath = $this->historyAdminService->getEntryContent($entry_id);
        $oldImageFullPath = $_SERVER['DOCUMENT_ROOT'] . $oldImagePath;

        // Delete the old image file if it exists
        if (file_exists($oldImageFullPath) && is_file($oldImageFullPath)) {
            unlink($oldImageFullPath);
        }

        header('Content-Type: application/json');

        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/History/';
            // Generating a unique filename to prevent file name conflicts and browser caching issues
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid("img_") . '.' . $extension;
            $targetFile = $targetDirectory . $uniqueFileName;

            // Move uploaded file and update entry with new image URL
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Constructing a relative URL to the uploaded image to return to the client
                $relativeUrl = '/img/History/' . $uniqueFileName;
                $this->historyAdminService->updateEntry($entry_id, $relativeUrl);
                echo json_encode(['success' => true, 'imageUrl' => $relativeUrl, 'message' => 'Image updated successfully.']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'No file uploaded or an error occurred.']);
        }
        exit();
    }

    public function updateTimeslot()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $success = $this->historyAdminService->updateTimeslot(
            $data['id'],
            $data['day'],
            $data['start_time'],
            $data['end_time'],
            $data['english_tour'],
            $data['dutch_tour'],
            $data['chinese_tour']
        );

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    //////////////////////////////// Deletes a specified timeslot using its ID ////////////////////////////////
    public function deleteTimeslot()
    {
        $timeslotId = $_GET['id'];
        if ($this->historyAdminService->deleteTimeslot($timeslotId)) {
            echo json_encode(['success' => true, 'message' => 'Timeslot deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete timeslot.']);
        }
    }

    //////////////////////////////// Adds a ticket to the cart. Decodes JSON data from the request, converts it to a Ticket model, and adds to the session ////////////////////////////////
    public function addToCart()
    {
        header('Content-Type: application/json');
        // Decode the JSON body from the incoming HTTP request
        $data = json_decode(file_get_contents('php://input'), true);
        $this->historyAdminService->addTicket($data);
        // Extract and store the selected language from the decoded data

        $ticket = $this->historyAdminService->convertHistoryTicketToTicket($data);
        session_start();
        $userId = $_SESSION['userId'];
        try {
            $this->userTicketService->addUserTicket($ticket, $userId);
            echo json_encode(['success' => true, 'message' => 'Ticket added to cart successfully.']);
        } catch (Exception $e) {
            error_log("Failed to add ticket to cart: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to add ticket to cart.']);
        }
    }
    ////////////////////////////////  Checks if a user session exists ////////////////////////////////
    //This method is used to verify if a user is currently logged in.
    public function checkUser()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            echo json_encode(['hasSession' => true]);
        } else {
            echo json_encode(['hasSession' => false]);
        }
    }

}
