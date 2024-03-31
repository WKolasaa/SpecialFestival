<?php 
include __DIR__ . '/../header.php'; 

// use App\Services\HistoryAdminService;
// $service = new HistoryAdminService();
?>

    <div class="festival-banner" style="background-image: url('../img/History/AmsterdamPort.png');">
            <div class="festival-info">
                <h1 class="festival-title"><?= $service->getContent("History Port", "Title") ?></h1>
            </div>
    </div>

    <!-- Back Button -->
    <div class="back-button-container">
        <a href="/HistoryMain" class="back-button">Back</a>
    </div>

    <div class="festival-description">
            <p><?= $service->getContent("History Port", "Festival Description") ?></p>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port First Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port First Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- <img src="../img/History/Amsterdam_Port_Pic_01.jpg" alt="Amsterdamse Poort History"> -->
            <?php
                $FirstImagePath = $service->getContent("History Port", "Amsterdam Port Image 1");
                // if($FirstImagePath == "<null>") {
                //     $FirstImagePath = "../img/History/Amsterdam_Port_Pic_01.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($FirstImagePath) ?>" alt="Amsterdam Port Image">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Second Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Second Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- <img src="../img/History/Amsterdam_Port_Pic_02.jpg" alt="Amsterdamse Poort Industrial Heritage"> -->
            <?php
                $SecondImagePath = $service->getContent("History Port", "Amsterdam Port Image 2");
                // if($SecondImagePath == "<null>") {
                //     $SecondImagePath = "../img/History/Amsterdam_Port_Pic_02.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($SecondImagePath) ?>" alt="Amsterdam Port Image">
        </div>
    </div>
    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Third Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Third Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- <img src="../img/History/Amsterdam_Port_Pic_03.jpg" alt="Amsterdamse Poort History"> -->
            <?php
                
                $ThirdImagePath = $service->getContent("History Port", "Amsterdam Port Image 3");
                // echo $ThirdImagePath;
                // if($ThirdImagePath == "<null>") {
                //     $ThirdImagePath = "../img/History/Amsterdam_Port_Pic_03.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($ThirdImagePath) ?>" alt="Amsterdam Port Image">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Fourth Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Fourth Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- <img src="../img/History/Amsterdam_Port_Pic_04.jpg" alt="Amsterdamse Poort Industrial Heritage"> -->
            <?php
                $FourthImagePath = $service->getContent("History Port", "Amsterdam Port Image 4");
                // if($FourthImagePath == "<null>") {
                //     $FourthImagePath = "../img/History/Amsterdam_Port_Pic_04.jpg";
                // }
            ?>
            <img src="<?= htmlspecialchars($FourthImagePath) ?>" alt="Amsterdam Port Image">
        </div>
    </div>

    <!-- Route Section -->
    <div class="route-section">
        <h2 class="route-title">Route</h2>
        <div class="route-content">
            <div class="map-container">
                <!-- <img src="../img/History/Map_Amsterdam_Port.png" alt="Map" class="map-image">  -->
                <?php
                    $portMapImagePath = $service->getContent("History Port", "Route Image");
                    // if($portMapImagePath == "<null>") {
                    //     $portMapImagePath = "../img/History/Map_Amsterdam_Port.png";
                    // }
                ?>
                <img src="<?= htmlspecialchars($portMapImagePath) ?>" alt="Route Image" class="map-image">
            </div>
            <div class="map-legend">
                <ul class="map-legend-list">
                    <li>1. <?= $service->getContent("History Port", "Amsterdam Port Map First Place") ?></li>
                    <li>2. <?= $service->getContent("History Port", "Amsterdam Port Map Second Place") ?></li>
                    <li>3. <?= $service->getContent("History Port", "Amsterdam Port Map Third Place") ?></li>
                    <li>4. <?= $service->getContent("History Port", "Amsterdam Port Map Fourth Place") ?></li>
                    <li>5. <?= $service->getContent("History Port", "Amsterdam Port Map Fifth Place") ?></li>
                    <li>6. <?= $service->getContent("History Port", "Amsterdam Port Map Sixth Place") ?></li>
                    <li>7. <?= $service->getContent("History Port", "Amsterdam Port Map Seventh Place") ?></li>
                    <li>8. <?= $service->getContent("History Port", "Amsterdam Port Map Eighth Place") ?></li>
                    <li>9. <?= $service->getContent("History Port", "Amsterdam Port Map Ninth Place") ?></li>
                </ul>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>   