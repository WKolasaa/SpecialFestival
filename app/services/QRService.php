<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QRService
{
    public function generateQRCode(){
        $data = 'Test Test';

// Instantiate QR code options
        $options = new QROptions([
            'version'      => 5, // QR version (1 - 40)
            'outputType'   => 'png', // Image format, // Error correction level (L stands for the lowest)
            'imageBase64'  => false // Disable base64 encoding
        ]);

// Instantiate QR code generator
        $qrcode = new QRCode($options);

// Set the file path where you want to save the QR code image
        $filePath = 'PDF/qrcode.png';

// Generate and save the QR code to a file
        file_put_contents($filePath, $qrcode->render($data));

        echo 'QR code saved to: ' . $filePath;
    }
}