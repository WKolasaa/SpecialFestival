<?php

namespace App\Controllers;

use App\Services\tokenservice;

class changepasswordcontroller
{
    public function index(){
        include '../views/changepassword.php';
    }

    public function checkToken(){
        $token = $_GET['token'];
        $email = $_GET['email'];

        $tokenService = new tokenservice();
        $response = $tokenService->checkToken($email, $token);
        if($response == "Token is valid"){
            include '../views/changepassword.php';
        }
        else if($response == "Token has expired") {
            echo "Token has expired!";
        }
        else{
            echo "Token is invalid!";
        }
    }

    public function changePassword(){ //TODO DO IT MANIAK!

    }
}