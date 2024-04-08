<?php

namespace App\Controllers;

use App\Services\PDFService;

class testcontroller
{
    public function index(){
        $pdfService = new PDFService();
        $pdfService->generatePDF();
    }
}