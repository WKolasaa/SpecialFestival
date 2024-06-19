<?php
include __DIR__ . '/header.php';
?>


<div class="container mt-5">
    <div class="col-md-6 offset-md-3">
        <h2 class="text-center mb-4">Forgot Password</h2>
        <div id="message" class="alert alert-light"></div>
        <form id="forgotPasswordForm">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <p></p>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
        </form>
    </div>
</div>

<script src="js/restorePassword.js"></script>

<?php
include __DIR__ . '/footer.php';
?>

