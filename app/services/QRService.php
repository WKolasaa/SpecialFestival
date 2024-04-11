<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Exception;

class QRService
{
    public function generateQRCode($ticket){ //TODO: handle Exception
        $data = 'TicketID='. $ticket->getTicketId() . '/UserID='. $_SESSION['userId'];

        $hash = hash('sha256', $data);
        $ticketRepository = new TicketRepository();
        if($ticketRepository->addQRCodeTicket($ticket->getTicketId(), $hash)){
            return (new QRCode)->render($hash);
        }

        throw new Exception("Error adding QR code to ticket");

    }

    public function scanQRCode($userTicketID){
        $ticketRepository = new TicketRepository();
        return $ticketRepository->scanQRCode($userTicketID);
    }

    public function qrCodeScanned($userTicketID){
        $ticketRepository = new TicketRepository();

        return $ticketRepository->qrCodeScanned($userTicketID);
    }

    public function getQrCode($userTicketID){
        $ticketRepository = new TicketRepository();
        return $ticketRepository->getQrCode($userTicketID);
    }

    public function getQRIDByCode($code){
        $ticketRepository = new TicketRepository();
        return $ticketRepository->getQRIDByCode($code);
    }
}