<?php

namespace App\Controllers;

use App\Services\TokenService;
use App\Services\UserService;

class RestorePasswordController
{
    function index()
    {
        include '../views/restorepassword.php';
    }

    function handleForgotPassword($email)
    {
        // Validate email (you can add more robust validation)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        // Check if the email exists in the database (using your model)
        $userService = new UserService();
        $user = $userService->getUserByEmail($email);

        if ($user) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));

            // Save the token in the database (using your model)
            $tokenService = new TokenService();
            $tokenService->updateResetToken($user['id'], $token);

            // Send reset email (you may use PHPMailer or similar)
            $subject = 'Password Reset Request';
            $body = "Click the following link to reset your password: http://yourdomain.com/reset_password.php?token=$token"; //TODO FINISH RESTORE PASSWORD
            mail($email, $subject, $body);

            return 'An email has been sent with instructions to reset your password.';
        } else {
            return 'Email address not found. Please register.';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a specific function is requested
    if (isset($_POST['action']) && $_POST['action'] == 'forgot_password') {
        // Call the handleForgotPassword function with the provided email
        echo handleForgotPassword($_POST['email']);
        exit();
    }
}