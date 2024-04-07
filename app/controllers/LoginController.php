<?php

namespace App\Controllers;


use App\Services\UserService;

class LoginController
{

    private $userService;

    public function __construct()
    {
        //$this->$userService = new UserService();
    }

    public function index()
    {
        include '../views/login.php';

    }

    public function login()
    {
        $loginInput = $_POST['username'];
        $password = $_POST['password'];
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $userService = new UserService();
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = $userService->loginByEmail($loginInput, $hashPassword);
        } else {
            $user = $userService->loginByUserName($loginInput, $hashPassword);
        }

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: /');
        } else {
            echo "Wrong username or password";
            var_dump($user);
        }
    }
}