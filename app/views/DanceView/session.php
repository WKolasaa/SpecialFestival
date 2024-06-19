<?php include __DIR__ . '/../header.php';
?>

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

<div class="secure-your-spot">Secure Your Spot Now!</div>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-12 d-flex flex-column align-items-end"> <!-- Change to flex-column and add align-items-end -->
      <nav>
        <ul class="nav nav-pills">
          <li class="nav-item1">
            <button class="nav-link  navButton buttonDay1" href="#">Day 1</button>
          </li>
          <li class="nav-item1">
            <button class="nav-link navButton buttonDay2" href="#">Day 2</button>
          </li>
          <li class="nav-item1">
            <button class="nav-link navButton buttonDay3" href="#">Day 3</button>
          </li>
        </ul>
      </nav>
      <div class="line-div"></div> <!-- This will now appear directly under the nav -->
    </div>
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
        <img class="group-child" src="" alt="">

      </div>
    </div>

    <div class="col-md-7">
      <div class="event-details p-3">
        <h1 class="artist-name"></h1>
        <p class="session"></p>
        <p class="location"><i class="fa fa-map-marker-alt"></i></p>
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

<!-- GOLDEN TICKET -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <div class="full-event-access-pass-parent">
        <b class="full-event-access">Full Event Access Pass! </b>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-4 text-center">
      <div class="friday-262024-parent">
        <div class="day-1">DAY 1</div>
      </div>
    </div>
    <div class="col-4 text-center">
      <div class="day-2-parent">
        <div class="day-2">DAY 2</div>
      </div>
    </div>
    <div class="col-4 text-center">
      <div class="day-3-parent">
        <div class="day-3">DAY 3</div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-4 text-center">
      <?php include __DIR__ . '/../../config/danceEventSchedule.php';
       ?>

      <div class="friday-262024-parent">
      <div class="friday-262024" data-date="<?php echo $dates[0] ?>">Friday <?php echo $dates[0] ?></div>
          </div>
    </div>
    <div class="col-4 text-center">
      <div class="day-2-parent">
        <div class="saturday-272024"  data-date="<?php echo $dates[1] ?>">Saturday <?php echo $dates[1] ?></div>
      </div>
    </div>
    <div class="col-4 text-center">
      <div class="day-3-parent">
        <div class="sunday-282024"  data-date="<?php echo $dates[2] ?>">Sunday <?php echo $dates[2] ?></div>
      </div>
    </div>
  </div>
</div>
<div class="goldenTicketContainer">
</div>
</div>

<script src="/js/DanceEvent/session.js"> </script>

<?php include __DIR__ . '/../footer.php'; ?>