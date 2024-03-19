<?php

namespace App\api\controllers;

use App\Services\UserService;

class changepasswordcontroller
{
    public function changePassword() {
        echo "runs";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $requestData = json_decode(file_get_contents("php://input"));

            if (isset($requestData->new_password) && isset($requestData->confirm_password)) {
                echo "runs";
                $newPassword = $requestData->new_password;
                $confirmPassword = $requestData->confirm_password;
                $email = $_SESSION["email"];

                if ($newPassword == $confirmPassword) {
                    echo "same password";
                    $userService = new UserService();
                    $userService->updatePassword($newPassword, $email);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => 'Passwords do not match']);
                }
            } else {
                echo json_encode(['error' => 'New password and confirm password not provided']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Invalid request method']);
        }
    }
}