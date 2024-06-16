<?php

namespace App\Controllers;

use App\Services\UserService;
use PDOException;

class signupcontroller
{
    function index()
    {
        include __DIR__ . '/../views/signup.php';
    }

    function captcha()
    {
        require_once __DIR__ . '/../config/captchaconfig.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $recaptchaResponse = $_POST['g-recaptcha-response'];
            $secretKey = $secretKeyCaptcha;  // Replace with your actual secret key

            // Send a request to the reCAPTCHA verification endpoint
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ];

            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result === false) {
                // Error handling
                die('Failed to contact reCAPTCHA verification server.');
            }

            $responseData = json_decode($result);

            if (!$responseData->success) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                // Set a session variable with the error message
                $_SESSION['error'] = 'CAPTCHA verification failed.';
                header('Location: /signup'); // Redirect back to the signup page
                exit();

            }

            $this->createUser();
        }
    }

    public function createUser()
    {
        $userName = $_POST['userName'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $photo = "";
        $phoneNumber = $_POST['phoneNumber'];

        $userService = new UserService();

        session_start();
        try {
            if ($userService->checkForUserName($userName)) {
                $this->returnError('Username already exists');
            } else if ($userService->checkForEmail($email)) {
                $this->returnError('Email already exists');
            } else {
                $userService->addUser($userName, $firstName, $lastName, $email, $password, $photo, $phoneNumber);
                $user = $userService->loginByUserName($userName, $password);
                $_SESSION['user'] = $user;
                $_SESSION['userId'] = $user->getId();
                $_SESSION['Email'] = $user->getEmail();
                $_SESSION['role'] = $user->getUserRole();
                header('Location: /');
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">An error occurred during registration.</div>';
            return "An error occurred during registration";
        }
    }

    private function returnError($message)
    {
        $_SESSION['error'] = $message;
        header('Location: /signup'); // Redirect back to the signup page
        exit();
    }
}