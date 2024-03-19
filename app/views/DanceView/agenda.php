<?php
include __DIR__ . '/../header.php';
?>

<div class="background-image"></div>


<div class="container content-section row1">
  <div class="row align-items-center">
    <div class="col-md-5 text">
      <h2 class="Day1">Day1</h2>
      <h3 class="date1"></h3>
      <p class="day-info">Kick off your Haarlem Festival experience on Friday! Explore the exciting agenda filled with
        electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
      </p>
      <button class="btn btn-danger day1">Get Tickets</button>

    </div>
    <div class="col-md-7 ">
      <table class="table" id="day1-table">
        <thead>
          <tr>
            <th scope="col">Session</th>
            <th scope="col">Time</th>
            <th scope="col">Price</th>
            <th scope="col">Tickets</th>
            <th scope="col" class="column-address">Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="artist-session"> <br></td>
            <td class="Time-duration"> <br></td>
            <td class="price"></td>
            <td class="ticketAvailable"></td>
            <td class="column-address"><br></td>
          </tr>

          <!-- More rows here -->
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Day 2 -->

<div class="container content-section row1">
  <div class="row align-items-center">
    <div class="col-md-7 ">
      <table class="table" id="day2-table">
        <thead>
          <tr>
            <th scope="col">Session</th>
            <th scope="col">Time</th>
            <th scope="col">Price</th>
            <th scope="col">Tickets</th>
            <th scope="col" class="column-address">Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="artist-session"> <br></td>
            <td class="Time-duration"><br></td>
            <td class="price"></td>
            <td class="ticketAvailable"></td>
            <td class="column-address"><br> </td>
          </tr>

          <!-- More rows here -->
        </tbody>
      </table>
    </div>
    <div class="col-md-5 text ">
      <h2 class="Day2">Day2</h2>
      <h3 class="date2"></h3>
      <p class="day-info">Kick off your Haarlem Festival experience on Friday! Explore the exciting agenda filled with
        electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
      </p>
      <button class="btn btn-danger day2">Get Tickets</button>
    </div>

    <!-- Day3 -->
    <div class="col-md-5 text">
      <h2 class="Day3">Day3</h2>
      <h3 class="date3"></h3>
      <p class="day-info">Kick off your Haarlem Festival experience on Friday! Explore the exciting agenda filled with
        electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
      </p>
      <button class="btn btn-danger day3">Get Tickets</button>

    </div>
    <div class="col-md-7 ">
      <table class="table" id="day3-table">
        <thead>
          <tr>
            <th scope="col">Session</th>
            <th scope="col">Time</th>
            <th scope="col">Price</th>
            <th scope="col">Tickets</th>
            <th scope="col" class="column-address">Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="artist-session"><br></td>
            <td class="Time-duration"><br></td>
            <td class="price"></td>
            <td class="ticketAvailable"></td>
            <td class="column-address"><br> </td>
          </tr>

          <!-- More rows here -->
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
</div>

<script src="/js/DanceEvent/danceAgenda.js"> </script>
<?php include __DIR__ . '/../footer.php'; ?>