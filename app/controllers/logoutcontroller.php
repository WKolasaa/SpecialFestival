<?php

namespace App\Controllers;

class logoutcontroller
{
    function index(){
        session_start();
        $_SESSION['user'] = null;
        session_destroy();
        header('Location: /');
    }
}