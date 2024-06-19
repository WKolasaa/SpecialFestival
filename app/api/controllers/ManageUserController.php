<?php

namespace App\Controllers;

use App\Services\UserService;
use Exception;

require_once 'basecontroller.php';


class ManageUserController extends BaseController
{
    private $userService;

    // initialize services
    function __construct()
    {
        $this->userService = new UserService();
    }


    public function index()
    {
        try {
            $this->setHeaders();
            $user = $this->userService->getAll();

            echo json_encode($user);

        } catch (Exception $e) {
            // Debugging: Log any exceptions

            echo json_encode(['error' => 'An error occurred while fetching user.']);
        }
    }


    public function updateUser()//update user by admin
    {
        // Handle POST request for updating user information
        header('Content-Type: application/json');

        // Check if request body is empty
        $jsonData = file_get_contents('php://input');
        if (empty($jsonData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request body']);
            return;
        }

        // Check if JSON decoding was successful
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }

        // Sanitize and validate the input data
        $sanitizedData = $this->sanitizeUserData($decodedData);
        if (!$this->isValidUserData($sanitizedData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Invalid user data']);
            return;
        }

        // Update user with sanitized data
        try {
            $this->userService->updateUserByAdmin($sanitizedData);
            echo json_encode(['message' => 'User information updated successfully']);
        } catch (Exception $e) {
            http_response_code(500); // Internal server error
            echo json_encode(['error' => 'Failed to update user information']);
        }
    }

    private function sanitizeUserData($data)
    {

        // $data['id'] = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        $data['username'] = filter_var($data['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        // $data['password'] = filter_var($data['password'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data['userRole'] = filter_var($data['userRole'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = filter_var($data['password'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $data;
    }

    private function isValidUserData($data)
    {

        return isset($data['username']) && isset($data['userRole']);
    }

    public function deleteUserByAdmin() //delete user by admin
    {
        header('Content-Type: application/json');

        try {
            $jsonData = file_get_contents('php://input');
            // Check if request body is empty
            if (empty($jsonData)) {
                http_response_code(400); // Bad request
                echo json_encode(['error' => 'Empty request body']);
                return;
            }

            // Debugging: Log the received data
            error_log('Received data: ' . $jsonData);

            // Check if JSON decoding was successful
            $decodedData = json_decode($jsonData, true);
            // Check if the ID is present in the decoded data
            if (!isset($decodedData['id'])) {
                http_response_code(400); // Bad request
                echo json_encode(['error' => 'Missing ID in request body']);
                return;
            }

            $this->userService->deleteUserByAdmin($decodedData);

        } catch (Exception $e) {
            // Debugging: Log any exceptions
            error_log('Exception: ' . $e->getMessage());

            echo json_encode(['error' => 'An error occurred while deleting user.']);
        }

    }

    public function createUserByAdmin() //add user by admin
    {
        header('Content-Type: application/json');

        // Check if request body is empty
        $jsonData = file_get_contents('php://input');
        if (empty($jsonData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Empty request body']);
            return;
        }

        // Check if JSON decoding was successful
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Error decoding JSON data']);
            return;
        }

        // Sanitize and validate the input data
        $sanitizedData = $this->sanitizeUserData($decodedData);
        if (!$this->isValidUserData($sanitizedData)) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Invalid user data']);
            return;
        }

        // Add user with sanitized data
        try {
            $this->userService->createUserByAdmin($sanitizedData);
            TODO:
            echo json_encode(['message' => 'User added successfully']);
        } catch (Exception $e) {
            http_response_code(500); // Internal server error
            echo json_encode(['error' => 'Failed to add user']);
        }
    }

}