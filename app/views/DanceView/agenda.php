<?php
include __DIR__ . '/../header.php';
// Create an associative array to store the date for each day
$dates = [
    'Friday' => '',
    'Saturday' => '',
    'Sunday' => ''
];

// Populate the dates array
foreach ($event as $e) {
    if ($e->getEventDay() === 'Friday' && empty($dates['Friday'])) {
        $dates['Friday'] = $e->getEventDate();
    } elseif ($e->getEventDay() === 'Saturday' && empty($dates['Saturday'])) {
        $dates['Saturday'] = $e->getEventDate();
    } elseif ($e->getEventDay() === 'Sunday' && empty($dates['Sunday'])) {
        $dates['Sunday'] = $e->getEventDate();
    }
}
?>

<div class="background-image"></div>

<!-- Friday -->

<div class="container content-section row1">
    <div class="row align-items-center">
        <div class="col-md-5 text">
            <h2 class="Day1">Day1</h2>
            <h3 class="date1">Friday <?php echo $dates['Friday']; ?></h3>
            <p class="day-info">Kick off your Haarlem Festival experience on Friday! Explore the exciting agenda filled
                with
                electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
            </p>
            <a href="/DanceEvent/session">
                <button class="btn btn-danger day1">Get Tickets</button>
            </a>
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
                <?php foreach ($event as $e): ?>
                    <?php if ($e->getEventDay() === 'Friday'): ?>
                        <tr>
                            <td class="artist-session"><?php echo $e->getArtistName(); ?><br></td>
                            <td class="Time-duration"><?php echo $e->getEventTime(); ?><br><span
                                        class="durationMinutesDay1">(<?php echo $e->getDurationMinutes(); ?> min)</span>
                            </td>
                            <td class="price">€ <?php echo $e->getSessionPrice(); ?></td>
                            <td class="ticketAvailable"><?php echo $e->getSessionsAvailable(); ?></td>
                            <td class="column-address"><?php echo $e->getVenueAddress(); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- More rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Saturday -->
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
                <?php foreach ($event as $e): ?>
                    <?php if ($e->getEventDay() === 'Saturday'): ?>

                        <tr>
                            <td class="artist-session"><?php echo $e->getArtistName(); ?> </td>
                            <td class="Time-duration"><?php echo $e->getEventTime(); ?><br><span
                                        class="durationMinutesDay2">(<?php echo $e->getDurationMinutes(); ?> min)</span>
                            </td>
                            <td class="price">€ <?php echo $e->getSessionPrice(); ?></td>
                            <td class="ticketAvailable"><?php echo $e->getSessionsAvailable(); ?></td>
                            <td class="column-address"><?php echo $e->getVenueAddress(); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- More rows here -->
                </tbody>
            </table>
        </div>
        <div class="col-md-5 text">
            <h2 class="Day2">Day2</h2>
            <h3 class="date2">Saturday <?php echo $dates['Saturday']; ?></h3>
            <p class="day-info">Kick off your Haarlem Festival experience on Saturday! Explore the exciting agenda
                filled with
                electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
            </p>
            <a href="/DanceEvent/session">
                <button class="btn btn-danger day2">Get Tickets</button>
            </a>
        </div>

    </div>
</div>


<!-- Sunday -->

<div class="container content-section row1">
    <div class="row align-items-center">
        <div class="col-md-5 text">
            <h2 class="Day3">Day3</h2>
            <h3 class="date3">Sunday <?php echo $dates['Sunday']; ?></h3>
            <p class="day-info">Kick off your Haarlem Festival experience on Sunday! Explore the exciting agenda filled
                with
                electrifying performances and events. Don't miss out – check the schedule and secure your tickets now.
            </p>
            <a href="/DanceEvent/session">
                <button class="btn btn-danger day3">Get Tickets</button>
            </a>
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
                <?php foreach ($event as $e): ?>
                    <?php if ($e->getEventDay() === 'Sunday'): ?>
                        <tr>
                            <td class="artist-session"><?php echo $e->getArtistName(); ?></td>
                            <td class="Time-duration"><?php echo $e->getEventTime(); ?><br><span
                                        class="durationMinutesDay3">(<?php echo $e->getDurationMinutes(); ?> min)</span>
                            </td>
                            <td class="price">€ <?php echo $e->getSessionPrice(); ?></td>
                            <td class="ticketAvailable"><?php echo $e->getSessionsAvailable(); ?></td>
                            <td class="column-address"><?php echo $e->getVenueAddress(); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- More rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="/js/DanceEvent/danceAgenda.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>

<!-- Test Push Dev -->