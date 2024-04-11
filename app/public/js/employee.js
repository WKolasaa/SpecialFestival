const codeReader = new ZXing.BrowserQRCodeReader();

codeReader.decodeFromInputVideoDevice(undefined, 'video').then(result => {
    console.log('Scan result:', result.text);

    // Send the scanned QR code to the server
    fetch('/process_qr_code.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ scannedQRCode: result.text })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message); // Log the response from the server
        })
        .catch(error => {
            console.error('Error:', error);
        });
}).catch(err => {
    console.error('Error:',err);
});