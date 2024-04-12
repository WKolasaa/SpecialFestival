<?php

namespace App\Controllers;

use App\Services\QRService;
use App\Services\TicketService;

class EmployeeController
{
    public function handleQRData()
    {
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);
        if(isset($jsonData)) {
            $QRService = new QRService();
            $data = json_encode($jsonData['qrData']);
            //echo $data;
            $ticketID = $QRService->getQRIDByCode($jsonData['qrData']);
            //echo "Ticket ID: " . $ticketID;
            session_start();
            if(isset($ticketID)) {
                if ($QRService->qrCodeScanned($ticketID)) {
                    $_SESSION['ticketID'] = $ticketID;
                    echo json_encode(['scanned' => true, 'message' => 'Ticket already scanned']);
                } else {
                    if ($QRService->scanQRCode($ticketID)) {
                        $_SESSION['ticketID'] = $ticketID;
                        echo json_encode(['scanned' => false, 'message' => 'Ticket scanned for the first time']);
                    } else {
                        echo json_encode(['error' => 'Error scanning ticket']);
                    }
                }
            } else {
                echo json_encode(['error' => 'Wrong QR code']);
            }
        } else {
            echo json_encode(['error' => 'No data provided']);
        }
    }

    public function getTicketInformation()
    {
        session_start();
        $ticketID = $_SESSION['ticketID'];
        if(isset($ticketID)) {
            $ticketService = new TicketService();
            $ticket = $ticketService->getTicketById($ticketID);
            if(isset($ticket)) {
                echo json_encode($ticket);
            } else {
                echo json_encode(['error' => 'Error getting ticket information']);
            }
        } else {
            echo json_encode(['error' => 'No ticket ID provided']);
        }
    }
}