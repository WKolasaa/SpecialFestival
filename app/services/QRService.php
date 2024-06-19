<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Exception;

class QRService
{
    private $ticketRepository;

    public function __construct()
    {
        $this->ticketRepository = new TicketRepository();
    }

    public function generateQRCode($ticket){ //TODO: handle Exception
        $data = $this->generateQRCodeData();

        while(!$this->checkForQRExistance($data)){
            $data = $this->generateQRCodeData();
        }

        $hash = hash('sha256', $data);
        if($this->ticketRepository->addQRCodeTicket($ticket->getTicketId(), $hash)){
            return (new QRCode)->render($hash);
        }

        throw new Exception("Error adding QR code to ticket");

    }

    public function scanQRCode($userTicketID){
        return $this->ticketRepository->scanQRCode($userTicketID);
    }

    public function qrCodeScanned($userTicketID){
        return $this->ticketRepository->qrCodeScanned($userTicketID);
    }

    public function getQrCode($userTicketID){
        return $this->ticketRepository->getQrCode($userTicketID);
    }

    public function getQRIDByCode($code){
        return $this->ticketRepository->getQRIDByCode($code);
    }

    private function generateQRCodeData($length = 32){
        return bin2hex(random_bytes($length / 2));
    }

    private function checkForQRExistance($data){
        if($this->ticketRepository->getQRIDByCode($data) === null){
            return true;
        } else {
            return false;
        }
    }
}