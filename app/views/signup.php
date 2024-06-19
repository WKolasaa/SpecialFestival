<?php
include __DIR__ . '/header.php';
require __DIR__ . '/../config/captchaconfig.php';

if(isset($_SESSION['user'])){ //checking of the user logged in or not
    $user = $_SESSION['user'];
}else{
    $user = null;
}
// var_dump($user);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    User Registration
                </div>
                <div class="card-body">
                    <!-- Registration Form -->
                    <div id="message" class="alert alert-light"></div>
                    <form id="signupForm">
                        <div class="form-group">
                        <input type="hidden" id="userId" name="id">
                        <input type="hidden" id="userRole" name="userRole">
                            <label for="userName">Username:</label>
                            <input type="text" class="form-control" id="userName" name="userName" required>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Phone Number:</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <p></p>

                        <div class="g-recaptcha" data-sitekey="<?php echo $sideKey ?>"></div>
                        <br/>
                        <button class="btn btn-primary" type="button" id="submitButton" onclick="onSubmit()"> Submit </button>
                        <?php
                        if ($user) {
                            // If the user is logged in, load the user.js file
                            echo '<button type="button" class="btn btn-danger btn-block" id="deleteButton">Delete</button>';
                            echo '<script src="js/user.js"></script>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/signup.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- <script src="js/signup.js"></script> -->


<?php
    include __DIR__ . '/footer.php';
?>

