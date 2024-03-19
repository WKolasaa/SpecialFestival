<?php include __DIR__ . '/../header.php'; ?>


<div class="background-image">
  <div class="overlay"></div> <!-- Add overlay div for brightness adjustment -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 introText">
        <p class="text-center">Get Ready for the Festival <br>Countdown!</p>
        <p class="paragraph-text">The Haarlem Festival awaits, and your ticket is just a click away! Dive into a world
          of incredible music, tracks, and experiences. Don't miss your chance to be part of this extraordinary event.
          Secure your tickets today and get ready for a festival adventure like no other. Join us in creating memories
          that will last a lifetime!</p>
      </div>
    </div>
  </div>
</div>





<div class="container mt-4">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-end">
      <nav>
        <ul class="nav nav-pills">
          <li class="nav-item">
            <button class="nav-link  navButton buttonDay1" href="#" >Day
              1</button>
          </li>
          <li class="nav-item">
            <button class="nav-link navButton buttonDay2" href="#" >Day 2</button>
          </li>
          <li class="nav-item">
            <button class="nav-link navButton buttonDay3" href="#">Day 3</button>
          </li>
        </ul>
      </nav>
    </div>
    <div class="line-div"></div>

  </div>
</div>

<div class="container mt-4">
  <div class="row align-items-center mt-4 ticket">
    <div class="col-md-2">
    <div class="flex-container">
      <div class="date-box text-center">

        <p class="month"></p>
        <p class="day"></p>
        <p class="day"></p>
        <p class="year"></p>
        
      </div>
      <img class="group-child" src="../img/DanceEvent/Default.jpg" alt="">

    </div>
    </div>

    <div class="col-md-7">
      <div class="event-details p-3">
        <h1 class="artist-name"></h1>
        <p class="session"></p>
        <p class="location"><i class="fa fa-map-marker-alt"></i> </p>
        <div class="time-price d-flex">
          <p><i class="fa fa-clock"></i> </p>
          <p class="price"><i class="fa fa-euro-sign"></i> </p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <button class="btn btn-danger btn-lg">
        <i class="fa fa-shopping-cart"></i> Add To Cart
      </button>
    </div>
  </div>
</div>






















<script src="/js/DanceEvent/session.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>