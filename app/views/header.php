<?php
include 'head.php';
?>
<nav id="header" class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">FESTIVAL HAARLEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div  class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDance" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dance
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownDance">
            <a class="dropdown-item" href="#">Artists</a>
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
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
            <a class="dropdown-item" href="/login">Login</a>
            <a class="dropdown-item" href="/manageuser">Signup</a>
            </div>
        </li>
        </ul>
  </div>
</nav>





