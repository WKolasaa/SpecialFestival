<?php include __DIR__ . '/../header.php'; ?>

    <style>
        #edit-link {
            position: fixed;
            top: 10px;
            right: 30px;
            z-index: 9999;
            font-size: 24px;
        }
    </style>

    <?php 
        use App\Models\UserRolesEnum;
        use App\Services\HistoryAdminService;

        if(isset($_SESSION['user']) && $_SESSION['user']->getUserRole() == UserRolesEnum::Administrator) {
            echo "<a id=\"edit-link\" href=\"/HistoryAdmin\">Edit</a>";
        }

        $service = new HistoryAdminService();
    ?>

    <div class="festival-banner" style="background-image: url('img/History/HistoryEvent.jpg');">
            <div class="festival-info">
                <h1 class="festival-title"><?= $service->getContent("History Main", "Title") ?></h1>
            </div>
    </div>

    <video autoplay muted loop class="history-video">
        <source src="img/History/MainPageVideo.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="festival-description">
            <p><?= $service->getContent("History Main", "Festival Description") ?></p>
    </div>

    <div class="locations-section">
        <h2 class="locations-title">Locations</h2>

        <div class="locations-container">
            <!-- Adriaan Windmill -->
            <a href="/HistoryWindmill" class="location-item">
            <div class="location-image-container">
                <?php
                // Assuming $service is an instance of HistoryAdminService initialized earlier
                $adriaanWindmillImagePath = $service->getContent("History Main", "Adriaan Windmill Image");
                if($adriaanWindmillImagePath == "<null>") {
                    // Provide a default image path or handle the absence of an image
                    $adriaanWindmillImagePath = "img/History/AdriaanWindmill.png";
                }
                ?>
                <img src="<?= htmlspecialchars($adriaanWindmillImagePath) ?>" alt="Adriaan Windmill" class="location-image">
            </div>
                <h3 class="location-name"><?= $service->getContent("History Main", "Seventh Location Name") ?></h3>
                <p class="location-description"><?= $service->getContent("History Main", "Seventh Location Description") ?></p>
            </a>

            <!-- Amsterdam Port -->
            <a href="/HistoryPort" class="location-item">
                <div class="location-image-container">
                <?php
                    // Assuming $service is an instance of HistoryAdminService initialized earlier
                    $amsterdamPortImagePath = $service->getContent("History Main", "Amsterdam Port Image");
                    if($amsterdamPortImagePath == "<null>") {
                        // Provide a default image path or handle the absence of an image
                        $amsterdamPortImagePath = "img/History/AmsterdamPort.png";
                    }
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
                <img src="img/History/Map_Route.png" alt="Map" class="map-image"> <!-- Replace with your map picture -->
                <!-- <div class="map-points"> -->
                    <!-- You can use absolute positioning to place your points based on the background image -->
                    <!-- <div class="map-point" style="top: 20%; left: 30%;">1</div> -->
                                                                                <!-- Replace top and left values with actual position -->
                    <!-- Repeat for other points -->
                <!-- </div> -->
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
                    <!-- Replace with your own image file -->
                    <img src="img/History/man.png" alt="Regular Ticket Icon">
                </div>
                <div class="ticket-info">
                    <h3 class="ticket-type">Regular Ticket:</h3>
                    <p class="ticket-price">Price: <?= $service->getContent("History Main", "Regular Ticket Price") ?></p>
                    <p class="ticket-drink">Drink: 1</p>
                </div>
            </div>
            <div class="ticket">
                <div class="ticket-icon">
                    <!-- Replace with your own image file -->
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
        <div class="days-container">
        <!-- Repeated day blocks for each day -->
        <?php
            $days = [
                $service->getContent("History Main", "First Day") => [
                    ['10:00 - 12:30', [$service->getContent("History Main", "First day morning tours")]], //time editable as well
                    ['13:00 - 15:30', [$service->getContent("History Main", "First day afternoon tours")]],
                    ['16:00 - 18:30', [$service->getContent("History Main", "First day evening tours")]],
                ],
                $service->getContent("History Main", "Second Day") => [
                    ['10:00 - 12:30', [$service->getContent("History Main", "Second day morning tours")]],
                    ['13:00 - 15:30', [$service->getContent("History Main", "Second day afternoon tours")]],//Chinese tours
                    ['16:00 - 18:30', [$service->getContent("History Main", "Second day evening tours")]],
                ],
                $service->getContent("History Main", "Third Day") => [
                    ['10:00 - 12:30', [$service->getContent("History Main", "Third day morning tours")]],
                    ['13:00 - 15:30', [$service->getContent("History Main", "Third day afternoon tours")]],//Chinese tours
                    ['16:00 - 18:30', [$service->getContent("History Main", "Third day evening tours")]],//Chinese tours
                ],
                // $service->getContent("History Main", "Fourth Day") => [
                //     ['10:00 - 12:30', ['English tours', 'Dutch tours', 'Chinese tours']],
                //     ['13:00 - 15:30', ['English tours', 'Dutch tours', 'Chinese tours']],
                //     ['16:00 - 18:30', ['English tours', 'Dutch tours']],
                // ],
                $service->getContent("History Main", "Fourth Day") => [
                    ['10:00 - 12:30', [$service->getContent("History Main", "Fourth day morning tours")]],//Chinese tours
                    ['13:00 - 15:30', [$service->getContent("History Main", "Fourth day afternoon tours")]],//Chinese tours
                    ['16:00 - 18:30', [$service->getContent("History Main", "Fourth day evening tours")]],
                ],
            ];

            foreach ($days as $day => $timeslots) {
                echo "<div class='day'>";
                echo "<h3 class='day-title'>{$day}</h3>";
                foreach ($timeslots as $timeslot) {
                    echo "<div class='timeslot'>";
                    echo "<div>{$timeslot[0]}</div>"; // Time e.g., '10:00 - 12:30'
                    foreach ($timeslot[1] as $tour) {
                        echo "<div>{$tour}</div>"; // Tour type e.g., 'English tours'
                    }
                    echo "</div>";
                }
                echo "</div>";
            }
        ?>
        </div>

        <div class="buy-tickets-button-container">
            <a href="#" class="buy-tickets-button">BUY TICKETS</a>
        </div>

    </div>

    <!-- Start Location Section -->
    <div class="start-location-section">
        <h2 class="start-location-title">Start location</h2>
        <div class="start-location-image-container">
            <img src="img/History/Start_Location_Grote_Markt.jpg" alt="Start Location" class="start-location-image">
            <!-- Marker Icon Here -->
            <div class="start-location-marker">
                <img src="img/History/location-mark.png" alt="Marker" class="marker-icon">
            </div>
        </div>
        <div class="start-location-address">
            <p><?= $service->getContent("History Main", "Start Location Address") ?></p>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>   