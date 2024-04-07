<?php

namespace App\Controllers;

use App\Services\TokenService;

class ChangePasswordController
{
    public function index()
    {
        $this->checkToken();
    }

    private function checkToken()
    {
        $token = $_GET['token'];
        $email = $_GET['email'];

        $tokenService = new TokenService();
        $response = $tokenService->checkToken($email, $token);
        if ($response == "Token is valid") {
            $_SESSION['email'] = $email;
            include '../views/changepassword.php';
        } else if ($response == "Token has expired") {
            echo "Token has expired!";
        } else {
            echo "Token is invalid!";
        }
    }

    public function changePassword()
    { //TODO DO IT MANIAK!

    }
}