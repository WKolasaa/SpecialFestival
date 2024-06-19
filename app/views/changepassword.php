<?php
include 'header.php';
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="message" class="alert alert-light"></div>
            <form id="changePasswordForm" onsubmit="return false;">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>"
                           readonly>
                </div>

                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" class="form-control" id="new-password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                </div>
                <p></p>
                <button type="submit" class="btn btn-primary" onclick="onSubmit()">Change Password</button>
            </form>

        </div>
    </div>
</div>

<script src="js/changePassword.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>

