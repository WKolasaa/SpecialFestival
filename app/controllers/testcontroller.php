<?php

namespace App\Controllers;

use App\Services\PDFService;
use App\Services\QRService;

class testcontroller
{
    public function index(){
        $qrService = new QRService();
        $qrService->generateQRCode();
    }
}