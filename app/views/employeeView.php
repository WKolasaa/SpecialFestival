<?php
    include __DIR__ . '/header.php';
?>
<h1>QR Code Scanner</h1>
<video id="video" width="300" height="200" style="border: 1px solid gray"></video>
<button id="startButton">Start Scanning</button>

<script src="app.js"></script>
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
document.getElementById('startButton').addEventListener('click', () => {
    const codeReader = new ZXing.BrowserQRCodeReader()
    console.log('ZXing code reader initialized')

    codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
            const firstDeviceId = videoInputDevices[0].deviceId
            codeReader.decodeFromVideoDevice(firstDeviceId, 'video', (result, err) => {
                if (result) {
                    console.log(result)
                    alert('QR Code content: ' + result.text)
                    // process the result here (e.g., redirecting, making a request, etc.)
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    console.error(err)
                    alert('Error scanning QR Code: ' + err.message)
                }
            })
        })
        .catch((err) => {
            console.error(err)
            alert('Error initializing camera: ' + err.message)
        })
});
</script>
<?php
    include __DIR__ . '/footer.php';
?>
