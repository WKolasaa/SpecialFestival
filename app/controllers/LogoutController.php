<?php

namespace App\Controllers;

class LogoutController
{
    function index()
    {
        session_start();
        $_SESSION['user'] = null;
        session_destroy();
        header('Location: /');
    }
}