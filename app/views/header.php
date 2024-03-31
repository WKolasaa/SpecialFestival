<?php
include 'head.php';
?>
<nav id="header" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="navbar-brand festival-parent">
        <p class="navBrand festival" href="#">FESTIVAL</p>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset ($_SESSION['user']) && $_SESSION['user']->getUserRole() == "ADMINISTRATOR"): ?>
                <!-- Admin navigation -->
                <li class="nav-item">
                    <a class="nav-link" href="/danceadmin">Dance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/history">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/yummy">Yummy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/orders">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/manageuser">Users</a>
                </li>
            <?php else: ?>
                <!-- Regular navigation -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDance" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dance
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownDance">
                        <a class="dropdown-item" href="/danceevent">Overview</a>
                        <a class="dropdown-item" href="/danceevent/artist">Artists</a>
                        <a class="dropdown-item" href="/danceevent/agenda">Agenda</a>
                        <a class="dropdown-item" href="/danceevent/session">Tickets</a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownYummy" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Yummy
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownYummy">
                        <a class="dropdown-item" href="#">Restaurants</a>
                        <a class="dropdown-item" href="#">Menu</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownHistory" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        History
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownHistory">
                        <a class="dropdown-item" href="#">Historic Events</a>
                        <a class="dropdown-item" href="#">Locations</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a id="festPlan" class="nav-link" href="#">FestPlan</a>
                </li>
            <?php endif; ?>

<<<<<<< HEAD
=======
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/yummy" id="navbarDropdownYummy" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <a id="admin"class="nav-link" href="manageuser">Admin</a>
            <a id="festPlan" class="nav-link" href="#">FestPlan</a>
        </li>
>>>>>>> development
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- Content to be conditionally rendered -->
                    <?php if (isset ($_SESSION['user'])): ?>
                        <!-- Logged in -->
                        <a class="dropdown-item" href="/edit-account">Edit Account</a>
                        <a class="dropdown-item" href="/logout">Log out</a>
                    <?php else: ?>
                        <!-- Logged out -->
                        <a class="dropdown-item" href="/login">Log in</a>
                        <a class="dropdown-item" href="/signup">Create an account</a>
                    <?php endif; ?>

                </div>
            </li>
        </ul>
    </div>
</nav>