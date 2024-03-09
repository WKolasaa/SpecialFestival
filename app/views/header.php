<?php
include 'head.php';
?>
<nav id="header" class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">FESTIVAL HAARLEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- TODO: we need to add a session here that checks whether the user is admin or not and based on that it will navigate to another direction. This will reduce creating another header only or the admin :) -->
  <div  class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/" id="navbarDropdownDance" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dance
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownDance">
            <a class="dropdown-item" href="#">Artists</a>
            <a class="dropdown-item" href="#">Agenda</a>
            <a class="dropdown-item" href="#">Tickets</a>
            </div>
        </li> -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/" id="navbarDropdownDance" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dance
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownDance">
                <a class="dropdown-item" href="/danceevent">Artists</a>
                <a class="dropdown-item" href="#">Agenda</a>
                <a class="dropdown-item" href="#">Tickets</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownYummy" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Yummy
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownYummy">
            <a class="dropdown-item" href="#">Restaurants</a>
            <a class="dropdown-item" href="#">Menu</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownHistory" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            History
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownHistory">
            <a class="dropdown-item" href="#">Historic Events</a>
            <a class="dropdown-item" href="#">Locations</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">FestPlan</a>
        </li>
        <li class="nav-item">
            <a id="admin"class="nav-link" href="manageuser">Admin</a>
        </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- Content to be conditionally rendered -->
                    <ul id="loggedOutContent" class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/login">Log in</a></li>
                        <li class="nav-item"><a class="nav-link" href="/signup">Create an account</a></li>
                    </ul>

                    <ul id="loggedInContent" class="navbar-nav" style="display: none;">
                        <li class="nav-item"><span class="nav-link">Welcome back!</span></li>
                        <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
  </div>
</nav>

<script>
    const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
    const userRole = <?php echo isset($_SESSION['user']) ? json_encode($_SESSION['user']->getUserRole()) : 'null'; ?>;


    // Conditional rendering
    const loggedOutContent = document.getElementById('loggedOutContent');
    const loggedInContent = document.getElementById('loggedInContent');
    const crudDropdownContainer = document.getElementById('crudDropdownContainer');

    admin.style.display='none';

    if (isLoggedIn) {
        loggedOutContent.style.display = 'none';
        loggedInContent.style.display = 'block';
        if(userRole=="ADMINISTRATOR"){
            admin.style.display = 'block';
            // link to admin page
            
        }
    } else {
        loggedOutContent.style.display = 'block';
        loggedInContent.style.display = 'none';
    }
</script>







