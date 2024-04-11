<?php
    include __DIR__ . '/header.php';
?>
    <h1>QR Code Scanner</h1>
    <div id="video-container">
        <video id="video" style="width: 100%; max-width: 400px;"></video>
    </div>
    <script src="https://unpkg.com/@zxing/library@latest"></script>

    <script src="js/employee.js"></script>

    <script>
        // Initialize QR code reader
        const codeReader = new ZXing.BrowserQRCodeReader();

        // Function to send scanned QR code to the server
        function sendScannedQRCode(scannedQRCode) {
            fetch('/process_qr_code.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ scannedQRCode: scannedQRCode })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message); // Log the response from the server
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Start scanning QR code
        codeReader.decodeFromInputVideoDevice(undefined, 'video').then(result => {
            console.log('Scan result:', result.text);
            // Send scanned QR code to the server
            sendScannedQRCode(result.text);
        }).catch(err => {
            console.error('Error:', err);
        });
    </script>

<?php
    include __DIR__ . '/footer.php';
?>