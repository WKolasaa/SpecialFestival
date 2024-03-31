<?php 
include __DIR__ . '/../header.php'; 

// use App\Services\HistoryAdminService;
// $service = new HistoryAdminService();
?>

    <div class="festival-banner" style="background-image: url('../img/History/AdriaanWindmill.png');">
            <div class="festival-info">
                <h1 class="festival-title"><?= $service->getContent("History Windmill", "Title") ?></h1>
            </div>
    </div>

    <!-- Back Button -->
    <div class="back-button-container">
        <a href="/HistoryMain" class="back-button">Back</a>
    </div>

    <div class="festival-description">
            <p><?= $service->getContent("History Windmill", "Festival Description") ?></p>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Windmill", "Adriaan Windmill First Title") ?></h2>
            <p><?= $service->getContent("History Windmill", "Adriaan Windmill First Description") ?></p>
        </div>
        <div class="heritage-image">
            <?php
                $FirstImagePath = $service->getContent("History Windmill", "Adriaan Windmill Image 1");
                // if($FirstImagePath == "<null>") {
                //     $FirstImagePath = "../img/History/Amsterdam_Windmill_Pic_01.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($FirstImagePath) ?>" alt="Adriaan Windmill Image">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Windmill", "Adriaan Windmill Second Title") ?></h2>
            <p><?= $service->getContent("History Windmill", "Adriaan Windmill Second Description") ?></p>
        </div>
        <div class="heritage-image">
            <?php
                $SecondImagePath = $service->getContent("History Windmill", "Adriaan Windmill Image 2");
                // if($SecondImagePath == "<null>") {
                //     $SecondImagePath = "../img/History/Amsterdam_Windmill_Pic_02.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($SecondImagePath) ?>" alt="Adriaan Windmill Image">
        </div>
    </div>
    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Windmill", "Adriaan Windmill Third Title") ?></h2>
            <p><?= $service->getContent("History Windmill", "Adriaan Windmill Third Description") ?></p>
        </div>
        <div class="heritage-image">
            <?php
                
                $ThirdImagePath = $service->getContent("History Windmill", "Adriaan Windmill Image 3");
                // echo $ThirdImagePath;
                // if($ThirdImagePath == "<null>") {
                //     $ThirdImagePath = "../img/History/Amsterdam_Windmill_Pic_03.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($ThirdImagePath) ?>" alt="Adriaan Windmill Image">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Windmill", "Adriaan Windmill Fourth Title") ?></h2>
            <p><?= $service->getContent("History Windmill", "Adriaan Windmill Fourth Description") ?></p>
        </div>
        <div class="heritage-image">
            <?php
                $FourthImagePath = $service->getContent("History Windmill", "Adriaan Windmill Image 4");
                // if($FourthImagePath == "<null>") {
                //     $FourthImagePath = "../img/History/Amsterdam_Windmill_Pic_04.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($FourthImagePath) ?>" alt="Adriaan Windmill Image">
        </div>
    </div>

    <!-- Route Section -->
    <div class="route-section">
        <h2 class="route-title">Route</h2>
        <div class="route-content">
            <div class="map-container">
                <?php
                    $WindmillMapImagePath = $service->getContent("History Windmill", "Route Image");
                    // if($WindmillMapImagePath == "<null>") {
                    //     $WindmillMapImagePath = "../img/History/Map_Amsterdam_Windmill.png";
                    // }
                ?>
                <img src="<?= htmlspecialchars($WindmillMapImagePath) ?>" alt="Route Image" class="map-image">
            </div>
            <div class="map-legend">
                <ul class="map-legend-list">
                    <li>1. <?= $service->getContent("History Windmill", "Adriaan Windmill Map First Place") ?></li>
                    <li>2. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Second Place") ?></li>
                    <li>3. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Third Place") ?></li>
                    <li>4. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Fourth Place") ?></li>
                    <li>5. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Fifth Place") ?></li>
                    <li>6. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Sixth Place") ?></li>
                    <li>7. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Seventh Place") ?></li>
                    <li>8. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Eighth Place") ?></li>
                    <li>9. <?= $service->getContent("History Windmill", "Adriaan Windmill Map Ninth Place") ?></li>
                </ul>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>   