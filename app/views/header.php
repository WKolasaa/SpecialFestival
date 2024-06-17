<?php
function loadPages(): false|array|null
{
    $pageManagementService = new App\Services\PageManagementService();
    return $pageManagementService->getAllPages();
}

$pages = loadPages();
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
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <!-- Additional navigation links with PHP condition for ADMINISTRATOR -->
                        <?php if (isset ($_SESSION['user']) && $_SESSION['user']->getUserRole() == "ADMINISTRATOR"): ?>
                            <!-- Admin navigation -->
                            <li class="nav-item active">
                                <a class="nav-link" href="/AdminView">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/AdminView/dance">Dance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/AdminView/history">History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/AdminView/yummy">Yummy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/AdminView/orders">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/AdminView/manageUser">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/PageManagement">Custom Pages</a>
                            </li>
                        <?php elseif (isset ($_SESSION['user']) && $_SESSION['user']->getUserRole() == "EMPLOYEE"): ?>
                            <!-- Employee navigation -->
                            <li class="nav-item active">
                                <a class="nav-link" href="/employee">Scan <span class="sr-only">(current)</span></a>
                            </li>

                        <?php else: ?>
                            <!-- Regular navigation -->
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDance" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dance
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownDance">
                                    <a class="dropdown-item" href="/DanceEvent">Overview</a>
                                    <a class="dropdown-item" href="/DanceEvent/artist">Artists</a>
                                    <a class="dropdown-item" href="/DanceEvent/agenda">Agenda</a>
                                    <a class="dropdown-item" href="/DanceEvent/session">Tickets</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownYummy" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Yummy
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownYummy">
                                    <a class="dropdown-item" href="/yummy">Overview</a>
                                    <a class="dropdown-item" href="/restaurants">Restaurant</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownHistory" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    History
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownHistory">
                                    <a class="dropdown-item" href="/HistoryMain">Historic Events</a>
                                    <a class="dropdown-item" href="/HistoryMain/port">Port</a>
                                    <a class="dropdown-item" href="/HistoryMain/windmill">Windmill</a>
                                </div>
                            </li>
                            <?php if (!empty($pages)): ?> <!-- Check if there are any custom pages -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCustomPages"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Information Pages
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownCustomPages">
                                        <?php foreach ($pages as $page): ?>
                                            <a class="dropdown-item"
                                               href="/PageManagement/showPage?pageId=<?= $page['pageId']; ?>">
                                                <?= $page['pageTitle'] ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a id="festPlan" class="nav-link" href="/FestPlan">FestPlan</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if (isset ($_SESSION['user'])): ?>
                                    <!-- Logged in -->
                                    <a class="dropdown-item" href="/signup">Edit Account</a>
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