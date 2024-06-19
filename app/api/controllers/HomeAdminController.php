<?php

namespace App\Controllers;

use App\Services\HomeContentService;

class HomeAdminController
{
    private $homeContentService;

    function __construct()
    {
        $this->homeContentService = new HomeContentService();
    }

    public function update()
    {
        // echo "update";
        $id = $_POST["id"];
        $content = $_POST["content"];

        // Assume updateEntry method returns true on success, false on failure
        $result = $this->homeContentService->updateEntry($id, $content);

        header('Content-Type: application/json');

        echo json_encode(['success' => true, 'message' => 'Content updated successfully.']);

        exit();
    }

    public function delete()
    {
        $id = $_GET["id"];
        $this->homeContentService->deleteEntry($id);
    }

    public function updateImage()
    {
        $id = $_POST["id"];

        // Get the current image path to delete it
        $oldImagePath = $this->homeContentService->getEntryContent($id);
        $oldImageFullPath = $_SERVER['DOCUMENT_ROOT'] . $oldImagePath;

        // Delete the old image file if it exists
        if (file_exists($oldImageFullPath) && is_file($oldImageFullPath)) {
            unlink($oldImageFullPath);
        }

        header('Content-Type: application/json');

        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/Home/';
            // Generating a unique filename to prevent file name conflicts and browser caching issues
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid("img_") . '.' . $extension;
            $targetFile = $targetDirectory . $uniqueFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Constructing a relative URL to the uploaded image to return to the client
                $relativeUrl = '/img/Home/' . $uniqueFileName;
                $this->homeContentService->updateEntry($id, $relativeUrl);
                // Ensure you return the full URL or a correct relative path that the client can resolve
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

    public function getEventsByDate() {
        $date = $_GET['date']; // Or handle date input validation more robustly
        $events = $this->homeContentService->getEventsByDate($date);
    
        header('Content-Type: application/json');
        echo json_encode($events);
        exit();
    }

    // Update an event
    public function updateEvent() {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = $this->homeContentService->updateEvent(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['date'],
            $data['startTime'],
            $data['endTime']
        );

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function deleteEvent() {
        error_log("Delete function called");
        $eventId = $_GET['id']; // Ensure this value is being correctly retrieved
        error_log("Attempting to delete event with ID: " . $eventId);
    
        if ($this->homeContentService->deleteEvent($eventId)) {
            error_log("Delete successful for ID: " . $eventId);
            echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
        } else {
            http_response_code(500);
            error_log("Delete failed for ID: " . $eventId);
            echo json_encode(['success' => false, 'message' => 'Failed to delete event.']);
        }
    }
    

}
