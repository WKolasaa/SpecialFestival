<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    public function generatePDF($ticket){ //TODO: Change the HTML for this
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $QRService = new QRService();
        $image = $QRService->generateQRCode($ticket);
        // Load HTML content for the invoice
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>Ticket</title>
        </head>
        <body>
        <h2>Ticket for '. $ticket->getTicketName() .'</h2>
        <img src="'. $image .'" width="400px" height="400px"> 
        <p>Ticket Date: ' . date('Y-m-d') . '</p>
        <p>Client Name: John Doe</p>
        <p>Phone Number: +1234567890</p>
        <p>Address: 123 Main Street, City, Country</p>
        <p>Email Address: john@example.com</p>
        <p>Subtotal Amount: $100.00</p>
        <p>VAT (21%): $21.00</p>
        <p>Total Amount: $121.00</p>
        <p>Payment Date: ' . date('Y-m-d', strtotime('+30 days')) . '</p>
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