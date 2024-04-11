<?php

namespace App\Services;

use App\Models\Ticket;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QRService
{
    public function generateQRCode($ticket){
        $data = 'TicketID='. $ticket->getTicketId() . '/TicketName='. $ticket->getTicketName();

        $hash = hash('sha256', $data);

        return (new QRCode)->render($hash);
    }
}