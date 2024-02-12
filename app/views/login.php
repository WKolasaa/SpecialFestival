<?php
    include __DIR__ . '/header.php'; 
 ?>
    <header class="fa-hero-login">
    <div class="container">
            <h1 class="intro-text">Login</h1>
        </div>
    </header>

<main class="container login-container">      
        <div class="col-md-5">
            <form action="/login/authenticate" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
        
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
        
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</main>

<?php
    include __DIR__ . '/footer.php';
?>