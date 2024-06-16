<?php

namespace App\Controllers;

use App\Services\UserService;

class ChangePasswordController
{
    public function changePassword()
    {
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        if (isset($jsonData["newPassword"]) && isset($jsonData["confirmPassword"]) && isset($jsonData["email"])) {
            $newPassword = $jsonData["newPassword"];
            $confirmPassword = $jsonData["confirmPassword"];
            $email = $jsonData["email"];

            if ($newPassword === $confirmPassword) {
                $userService = new UserService();
                $userService->updatePassword($newPassword, $email);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Passwords do not match']);
            }
        } else {
            echo json_encode(['error' => 'New password and confirm password not provided']);
        }
    }
}