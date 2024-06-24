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
                    <form id="signupForm" action="signup/captcha" method="POST">
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


                        <?php
                        if (isset($user)) {
                            // If the user is logged in, load the user.js file
                            echo '<button type="button" class="btn btn-success" id="updateButton" onclick="updateUser()">Update</button>';
                            echo ' ';
                            echo '<button type="button" class="btn btn-danger btn-block" id="deleteButton">Delete</button>';
                            echo '<script src="js/user.js"></script>';
                        }
                        else{
                            echo '<div class="g-recaptcha" data-sitekey="' . $sideKey .'"></div>';
                            echo '<br/>';
                            echo '<input class="btn btn-primary" type="submit" value="Sign in">';
                            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';

                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- <script src="js/signup.js"></script> -->


<?php
    include __DIR__ . '/footer.php';
?>

