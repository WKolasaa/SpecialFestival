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
}
