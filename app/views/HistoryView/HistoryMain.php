<?php include __DIR__ . '/../header.php'; ?>

<div class="festival-banner" style="position: relative;">
    <?php
        $SecondImagePath = $service->getContent("History Main", "History Intro Image");
    ?>
    <img src="<?= htmlspecialchars($SecondImagePath) ?>" alt="History Introduction Image" style="width: 100%; height: auto; display: block;">
    <div class="festival-info" style="position: absolute; bottom: 0; left: 0; padding: 10px; color: white; text-align: left;">
        <h1 class="festival-title"><?= $service->getContent("History Main", "Title") ?></h1>
    </div>
</div>
    
<video autoplay muted loop class="history-video">
    <source src="../img/History/MainPageVideo.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="festival-description">
    <p><?= $service->getContent("History Main", "Festival Description") ?></p>
</div>

<div class="locations-section">
    <h2 class="locations-title">Locations</h2>

    <div class="locations-container">
        <!-- Adriaan Windmill -->
        <a href="HistoryMain/windmill" class="location-item">
            <div class="location-image-container">
                <?php
                $adriaanWindmillImagePath = $service->getContent("History Main", "Adriaan Windmill Image");
                ?>
                <!-- htmlspecialchars - converts special characters to their html enteties-->
                <img src="<?= htmlspecialchars($adriaanWindmillImagePath) ?>" alt="Adriaan Windmill" class="location-image">
            </div>
            <h3 class="location-name"><?= $service->getContent("History Main", "Seventh Location Name") ?></h3>
            <p class="location-description"><?= $service->getContent("History Main", "Seventh Location Description") ?></p>
        </a>

        <!-- Amsterdam Port -->
        <a href="HistoryMain/port" class="location-item">
            <div class="location-image-container">
                <?php
                $amsterdamPortImagePath = $service->getContent("History Main", "Amsterdam Port Image");
                ?>
                <img src="<?= htmlspecialchars($amsterdamPortImagePath) ?>" alt="Amsterdam Port" class="location-image">
            </div>
            <h3 class="location-name"><?= $service->getContent("History Main", "Eighth Location Name") ?></h3>
            <p class="location-description"><?= $service->getContent("History Main", "Eighth Location Description") ?></p>
        </a>
    </div>
</div>

<!-- Route Section -->
<div class="route-section">
    <h2 class="route-title">Route</h2>
    <div class="route-content">
        <div class="map-container">
            <?php
            $homeMapImagePath = $service->getContent("History Main", "Route Image");
            ?>
            <img src="<?= htmlspecialchars($homeMapImagePath) ?>" alt="Map image" class="map-image">
        </div>
        <div class="map-legend">
            <ul class="map-legend-list">
                <li>1. Church of St.Bavo</li>
                <li>2. Grote Markt</li>
                <li>3. De Hallen</li>
                <li>4. Proveniershof</li>
                <li>5. Jopenpark</li>
                <li>6. Wallse Kerk</li>
                <li>7. Molen de Adriaan</li>
                <li>8. Amsterdamse Poort</li>
                <li>9. Hof van Bakenes</li>
            </ul>
        </div>
    </div>
</div>

<!-- Tickets Section -->
<div class="tickets-section">
    <h2 class="tickets-title">Available timeslots</h2>
    <div class="ticket-container">
        <div class="ticket">
            <div class="ticket-icon">
                <img src="../img/History/man.png" alt="Regular Ticket Icon">
            </div>
            <div class="ticket-info">
                <h3 class="ticket-type">Regular Ticket:</h3>
                <p class="ticket-price">Price: <?= $service->getContent("History Main", "Regular Ticket Price") ?></p>
                <p class="ticket-drink">Drink: 1</p>
            </div>
        </div>
        <div class="ticket">
            <div class="ticket-icon">
                <img src="img/History/family.png" alt="Family Ticket Icon">
            </div>
            <div class="ticket-info">
                <h3 class="ticket-type">Family Ticket:</h3>
                <p class="ticket-price">Price: <?= $service->getContent("History Main", "Family Ticket Price") ?></p>
                <p class="ticket-drink">Drink: 1 (per person)</p>
            </div>
        </div>
    </div>
</div>

<!-- Timeslots Section -->
<div class="timeslots-section">
    <h2 class="timeslots-title">Timeslots</h2>
    <?php
    $timeslots = $service->getAllTimeslots(); // Fetch timeslots from the service
    foreach ($timeslots as $timeslot):
        // Convert the 'day' from Y-m-d to a more readable format
        $formattedDate = date("F j, Y", strtotime($timeslot->getDay()));
    ?>
        <div class="timeslot">
            <h3>Date: <?= htmlspecialchars($formattedDate) ?></h3>
            <p><strong>Time:</strong> <?= htmlspecialchars($timeslot->getStartTime()) ?> - <?= htmlspecialchars($timeslot->getEndTime()) ?></p>
            <div class="languages">
                <span class="badge">English: <?= htmlspecialchars($timeslot->getEnglishTour()) ?></span>
                <span class="badge">Dutch: <?= htmlspecialchars($timeslot->getDutchTour()) ?></span>
                <span class="badge">Chinese: <?= htmlspecialchars($timeslot->getChineseTour()) ?></span>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="buy-tickets-button-container">
        <a href="/HistoryMain/cart" class="buy-tickets-button">BUY TICKETS</a>
    </div>
</div>

<!-- Start Location Section -->
<div class="start-location-section">
    <h2 class="start-location-title">Start location</h2>
    <div class="start-location-image-container">
        <?php
            $startLocationImagePath = $service->getContent("History Main", "Start Location Image");
        ?>
        <img src="<?= htmlspecialchars($startLocationImagePath) ?>" alt="Start Location" class="start-location-image">
        <div class="start-location-marker">
            <img src="../img/History/location-mark.png" alt="Marker" class="marker-icon">
        </div>
    </div>
    <div class="start-location-address">
        <p><?= $service->getContent("History Main", "Start Location Address") ?></p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
