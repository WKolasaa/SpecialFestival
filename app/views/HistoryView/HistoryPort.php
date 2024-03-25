<?php 
include __DIR__ . '/../header.php'; 

use App\Services\HistoryAdminService;
$service = new HistoryAdminService();
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

<!-- Rest of your existing code... -->

    <div class="festival-description">
            <p><?= $service->getContent("History Port", "Festival Description") ?></p>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port First Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port First Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- Replace 'path_to_image.jpg' with the actual path to your image file -->
            <img src="../img/History/Amsterdam_Port_Pic_01.jpg" alt="Amsterdamse Poort History">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Second Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Second Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- Replace 'path_to_image.jpg' with the actual path to your image file -->
            <img src="../img/History/Amsterdam_Port_Pic_02.jpg" alt="Amsterdamse Poort Industrial Heritage">
        </div>
    </div>
    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Third Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Third Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- Replace 'path_to_image.jpg' with the actual path to your image file -->
            <img src="../img/History/Amsterdam_Port_Pic_03.jpg" alt="Amsterdamse Poort History">
        </div>
    </div>

    <div class="heritage-section">
        <div class="heritage-text">
            <h2 class="heritage-title"><?= $service->getContent("History Port", "Amsterdam Port Fourth Title") ?></h2>
            <p><?= $service->getContent("History Port", "Amsterdam Port Fourth Description") ?></p>
        </div>
        <div class="heritage-image">
            <!-- Replace 'path_to_image.jpg' with the actual path to your image file -->
            <img src="../img/History/Amsterdam_Port_Pic_04.jpg" alt="Amsterdamse Poort Industrial Heritage">
        </div>
    </div>

    <!-- Route Section -->
    <div class="route-section">
        <h2 class="route-title">Route</h2>
        <div class="route-content">
            <div class="map-container">
                <img src="../img/History/Map_Amsterdam_Port.png" alt="Map" class="map-image"> <!-- Replace with your map picture -->
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

<?php include __DIR__ . '/../footer.php'; ?>   