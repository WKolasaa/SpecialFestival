<?php

namespace App\Controllers;

use App\Repositories\TicketRepository;
use App\Services\EmailService;
use App\Services\PDFService;
use chillerlan\QRCode\QRCode;

class testcontroller //TODO: REMOVE THIS FILE
{
    public function index(){
        $emailService = new EmailService();
        try{
            $emailService->sendTickets();
        } catch (\Exception $e){
            echo $e->getMessage();
        }

    }
}