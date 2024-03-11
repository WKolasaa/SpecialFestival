<?php
    include 'header.php';
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <form action="changepassword/changePassword" method="POST">
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" class="form-control" id="new-password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                </div>
                <p></p>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>

        </div>
    </div>
</div>

<?php
    include 'footer.php';
?>


