<?php
include __DIR__ . '/header.php';
?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="username">Username or Email:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div id="passwordHelpBlock" class="form-text">
                                Forgot password? <a href="/RestorePassword">Click here</a>
                            </div>
                            <p></p>
                            <button type="button" class="btn btn-primary" onclick="login()">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/login.js"></script>


<?php
include __DIR__ . '/footer.php';
?>