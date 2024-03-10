<?php
include __DIR__ . '/header.php';
?>

<head>

</head>
<body>
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
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <p></p>

                        <div class="g-recaptcha" data-sitekey="6LdMtIEpAAAAAItp4USCkfo9OHBPXjlxo1mz-hVI"></div>
                        <br/>
                        <input class="btn btn-primary" type="submit" value="Submit" onclick="submitForm()">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<scrip src="js/signup.js"></scrip>

<?php
    include __DIR__ . '/footer.php';
?>


</body>