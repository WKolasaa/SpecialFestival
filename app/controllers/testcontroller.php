<?php

namespace App\Controllers;
require '../vendor/phpqrcode/qrlib.php';

use App\Services\PDFService;

class TestController
{
    public function index(){
        $pdfService = new PDFService();
        $pdfService->generatePDF();

        $data='Some Text';
        $filename = 'qrcode.png';
        echo '<img src="'.$filename.'" />';

    }
}