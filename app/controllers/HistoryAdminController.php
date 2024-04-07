<?php

namespace App\Controllers;

use App\Models\HistoryEntryTypeEnum;
use App\Services\HistoryAdminService;

class HistoryAdminController
{
    private $historyAdminService;

    public function __construct()
    {
        $this->historyAdminService = new HistoryAdminService();
    }

    public function index()
    {
        $entries = $this->historyAdminService->getAll();
        include '../views/HistoryView/HistoryAdmin.php';
    }

    public function addEntry()
    {
        $page_name = $_POST["page_name"];
        $entry_name = $_POST["entry_name"];
        $entry_type = $_POST["entry_type"];
        $content = $_POST["content"];

        if (empty($page_name) || empty($entry_name) || empty($entry_type) || empty($content)) {
            echo "Wrong input.";
        } else {
            $entry_type = $entry_type == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;
            $this->historyAdminService->addEntry($page_name, $entry_name, $entry_type, $content);
            header("Location: /HistoryAdmin");
        }

        if ($entry_type == HistoryEntryTypeEnum::Image) {
            if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
                // Define the path to the upload directory
                $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/img/History/';
                $targetFile = $targetDirectory . basename($_FILES['image']['name']);
                // Move the uploaded file to your directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // File is successfully uploaded
                    // You can now save the $targetFile (or a relative path) in your database
                    $content = $targetFile; // Assuming you want to save the absolute path
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

}