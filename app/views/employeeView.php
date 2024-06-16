<?php
include __DIR__ . '/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">QR Code Scanner</h1>
                    <div class="text-center">
                        <video id="video" width="300" height="200" style="border: 1px solid gray"></video>
                    </div>
                    <div class="text-center mt-3">
                        <button id="startButton" class="btn btn-primary">Start Scanning</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" id="ticketInfoCard">
                    <!-- You can add content dynamically here using JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/employee.js"></script>
<script src="https://unpkg.com/@zxing/library@latest"></script>

<?php
include __DIR__ . '/footer.php';
?>
