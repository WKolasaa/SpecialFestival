<?php

namespace App\Controllers;

use App\Services\EmailService;
use App\Services\TokenService;
use App\Services\UserService;
use Exception;

class RestorePasswordController
{
    function index()
    {

    }

    public function checkEmailExistsAndSendToken()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $requestData = json_decode(file_get_contents("php://input"));

            // Ensure 'email' is set in the request data
            if (isset($requestData->email)) {
                $email = $requestData->email;

                $userService = new UserService();
                $tokenService = new TokenService();
                $emailService = new EmailService();

                try {
                    // Check if the email exists
                    if ($userService->checkForEmail($email)) {
                        // Generate and store a reset token for the user
                        $token = $tokenService->generateRandomToken(); // Implement your token generation logic
                        $tokenService->storeOrUpdateToken($email, $token);

                        // Send an email with the reset token
                        $emailService->sendResetTokenEmail($email, $token);
                        // Return a JSON response indicating success
                        echo json_encode(['success' => true]);
                        return ['success' => true];
                    } else {
                        // Email does not exist
                        echo json_encode(['error' => 'Email does not exist']);
                        exit();
                    }
                } catch (Exception $e) {
                    // Log or handle the exception
                    http_response_code(500);
                    echo json_encode(['error' => 'Internal Server Error']);
                    exit();
                }
            } else {
                // 'email' not provided in the request
                http_response_code(400);
                echo json_encode(['error' => 'Email not provided']);
                exit();
            }
        }

        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        exit();
    }
}