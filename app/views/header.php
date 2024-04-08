?php
include 'head.php';
?>
<nav id="header" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- "FESTIVAL" Branding on the Left -->
        <div class="navbar-brand festival-parent">
            <p class="navBrand festival" href="#">FESTIVAL</p>
        </div>

        <!-- Elements Aligned to the Right -->
        <div class="d-flex justify-content-end" style="width: 100%;">
            <!-- Toggle Button for Offcanvas Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Offcanvas Menu, now aligned to end -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- Additional navigation links with PHP condition for ADMINISTRATOR -->
                        <?php if (isset ($_SESSION['user']) && $_SESSION['user']->getUserRole() == "ADMINISTRATOR"): ?>
                            <!-- Admin navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="/danceadmin">Dance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/HistoryAdmin">History</a>
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

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
            </div>
        </div>
    </div>
</nav>

<!-- Bootstrap Bundle with Popper -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>