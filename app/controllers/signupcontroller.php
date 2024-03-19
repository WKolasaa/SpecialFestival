<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserService;
use PDOException;

class signupcontroller
{
    function index()
    {
        include __DIR__ . '/../views/signup.php';
    }

    function captcha(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $recaptchaResponse = $_POST['g-recaptcha-response'];
            $secretKey = "6LdMtIEpAAAAAMuB5xeiQnbtHZ97L14-TZyEtUPJ";  // Replace with your actual secret key

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
                echo('CAPTCHA verification failed.');
                die('CAPTCHA verification failed.');
            }

            $this->createUser();
        }
    }

    private function createUser(){
        $userName = $_POST['userName'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $photo = "";

        $userService = new UserService();
        try{
            if($userService->checkForUserName($userName)){
                echo '<div class="alert alert-danger">Username already exists</div>'; //TODO: Display error message in the view
                return "Username already exists";
            }
            else if($userService->checkForEmail($email)){
                echo '<div class="alert alert-danger">Email already exists</div>';
                return "Email already exists";
            }
            else{
                // TODO: we can to have a user session so when the user logged in the navbar will show 
                $userService->addUser($userName, $firstName, $lastName, $email, $hashedPassword, $photo);
               

            }
        }catch (PDOException $e) {
            echo '<div class="alert alert-danger">An error occurred during registration.</div>';
            return "An error occurred during registration";
        }

        $_SESSION['user'] = $userService->loginByUserName($userName, $hashedPassword);
        header('Location: /');
    }
}