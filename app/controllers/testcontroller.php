<?php

namespace App\Controllers;

use App\Services\EmailService;
use Exception;

class testcontroller //TODO: REMOVE THIS FILE
{
    public function index()
    {
        $emailService = new EmailService();
        try {
            $emailService->sendTickets();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}