<?php

namespace App\Controllers;

use App\Services\PDFService;
use chillerlan\QRCode\QRCode;
use Dompdf\Dompdf;
use Dompdf\Options;

class testcontroller
{
    public function index(){
        $data = 'https://www.youtube.com/watch?v=yIbFWe9HA-8';

        $code = (new QRCode)->render($data);

        // quick and simple:
        echo $code;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '<img src="' . $code . '" alt="QR Code" />';


        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $pdfContent = $dompdf->output();

        // Save the PDF to a file
        $filePath = 'PDF/invoice.pdf'; // Specify the file path where you want to save the PDF
        file_put_contents($filePath, $pdfContent);
    }
}