<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    public function generatePDF($ticket){ 
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        //session_start();
        $QRService = new QRService();
        $image = $QRService->generateQRCode($ticket);
        // Load HTML content for the invoice
        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Ticket Information</title>
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    margin: 40px;
                    color: #333;
                }
                .ticket-header {
                    background-color: #f2f2f2;
                    padding: 10px;
                    text-align: center;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                }
                .ticket-img {
                    display: block;
                    margin: 20px auto;
                    width: 400px;
                    height: 400px;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                }
                .customer-info, .date-info {
                    margin-top: 20px;
                    font-size: 16px;
                    line-height: 1.5;
                }
                .customer-info b, .date-info b {
                    color: #555;
                }
            </style>
            </head>
            <body>
                <div class="ticket-header">
                    <h2>Ticket for '. htmlspecialchars($ticket->getTicketName()) .'</h2>
                </div>
                <img src="'. htmlspecialchars($image) .'" alt="Ticket Image" class="ticket-img">
                <div class="customer-info">
                    <p>Customer name: <b>' . htmlspecialchars($_SESSION['user']->getFirstName()) . ' ' . htmlspecialchars($_SESSION['user']->getLastName()) . '</b></p>
                </div>
                <div class="date-info">
                    <p>Start Date: <b>'. htmlspecialchars($ticket->getStartDate()->format('Y-m-d')) .'</b></p>
                    <p>Start Time: <b>' . htmlspecialchars($ticket->getStartDate()->format('H:i:s')) .'</b></p>
                </div>
            </body>
            </html>
           ';

        // Load HTML into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        return $dompdf->output();
    }
}