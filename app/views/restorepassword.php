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

<?php
    include __DIR__ . '/footer.php';
?>


<script>
    function submitForm() {
        var email = document.getElementById('email').value;

        // Validate email (you can add more robust validation)
        if (!isValidEmail(email)) {
            document.getElementById('message').innerHTML = '<div class="alert alert-danger">Please enter a valid email address.</div>';
            return;
        }

        // Send email and action to PHP for further processing
        $.ajax({
            type: 'POST',
            url: 'controllers/restorepasswordcontroller.php',
            data: { action: 'handleForgotPassword', email: email },
            success: function(response) {
                // Display response message
                document.getElementById('message').innerHTML = '<div class="alert alert-info">' + response + '</div>';
            }
        });
    }

    function isValidEmail(email) {
        // Implement a simple email validation logic
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
