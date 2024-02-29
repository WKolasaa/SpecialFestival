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
                        <!-- Login Form -->
                        <form action="/login/login" method="POST">
                            <div class="form-group">
                                <label for="username">Username or Email:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div id="passwordHelpBlock" class="form-text">
                                Forgot password? <a href="/restorepassword">Click here</a>
                            </div>
                            <p></p>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    include __DIR__ . '/footer.php';
?>