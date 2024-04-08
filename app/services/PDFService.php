<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    public function generatePDF(){
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML content for the invoice
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>Invoice</title>
        </head>
        <body>
        <h2>Invoice</h2>
        <p>Invoice Number: INV-123456</p>
        <p>Invoice Date: ' . date('Y-m-d') . '</p>
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

        $pdfContent = $dompdf->output();

        // Save the PDF to a file
        $filePath = 'PDF/invoice.pdf'; // Specify the file path where you want to save the PDF
        file_put_contents($filePath, $pdfContent);

        $emailService = new EmailService();
        try{
            $emailService->sendInvoice($pdfContent);
        }catch (\Exception $e) {
            echo 'Failed to send email: ' . $e->getMessage();
        }

        echo 'PDF saved successfully at: ' . $filePath;
    }
}