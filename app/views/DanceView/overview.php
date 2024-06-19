<?php include __DIR__ . '/../header.php';
// Prepare data
$overviewData = [];
for ($i = 0; $i < 5; $i++) {
    if (isset($overviews[$i])) {
        $overviewData[$i] = [
            'header' => $overviews[$i]->getHeader(),
            'subHeader' => $overviews[$i]->getSubHeader(),
            'text' => $overviews[$i]->getText(),
            'imageName' => $overviews[$i]->getImageName(),
        ];
    }
} ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<video autoplay muted loop class="video-background">
    <source src="img/DanceEvent/IntroVideo.mp4" type="video/mp4">
</video>

<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-6 d-flex align-items-end justify-content-start">
            <div class="text-white overlay-text festival-title">
                <h1>Move & Flow Festival </h1>
                <h2>HAARLEM</h2>
            </div>
        </div>
        <div class="col-6 d-flex align-items-end justify-content-end">
            <div class="text-white overlay-text festival-date text-center">
                <!-- <h3>July 26-28, 2024</h3> -->
                <h3 class="overview-title">
                    <?= $overviewData[0] ['header'] ?>
                </h3>

                <hr class="golden-line">
                <!-- <p>Unleash the Beat, Move Your Feet</p>
                <p>Join the Dance Celebration!</p> -->
                <p class="overview-subtitle">
                    <?= $overviewData[0] ['subHeader'] ?>
                </p>
                <p class="overview-text">
                    <?= $overviewData[0] ['text'] ?>
                </p>
                <!-- <p>(Unforgettable Dance Experience)</p> -->
            </div>
        </div>
    </div>
</div>


<div class="container-fluid text-center my-class d-flex flex-column justify-content-center align-items-center"
     style="height: 100vh;">
    <h1 class="countdown-title">Countdown <i class="far regular fa-hourglass"></i>
    </h1>

    <h2 class="countdown-subtitle"> <?= $overviewData[1] ['header'] ?></h2>
    <div class="countdown-details">
        <p> <?= $overviewData[1] ['text'] ?></p>
    </div>

    <div class="countdown-dates">
        <?= $overviewData[1] ['subHeader'] ?>
        <!-- July 26-28 -->
    </div>
</div>
<!-- CARD SLIDER -->
<section class="section">
    <div class="swiper mySwiper container">
        <div class="swiper-wrapper content">
            <!-- Cards will be inserted here by JavaScript -->
        </div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</section>

<div class="container desc1">
    <div class="row">
        <div class="col-md-6 ">
            <h1 class="sessionType"> <?= $overviewData[2] ['header'] ?></h1>
            <h4 class="DateAndTime"> <?= $overviewData[2] ['subHeader'] ?></h4>
            <p class="sessionDescription"> <?= $overviewData[2] ['text'] ?></p>
        </div>
        <div class="col-md-6 image-container">
            <img src="img/DanceEvent/<?= $overviewData[2] ['imageName'] ?>" alt="Your Image Description"
                 class="img-fluid image1">
        </div>
    </div>
</div>

<div class="container desc1">
    <div class="row">

        <div class="col-md-6 image-container">
            <img src="img/DanceEvent/<?= $overviewData[3] ['imageName'] ?>" alt="Your Image Description"
                 class="img-fluid image22">
        </div>
        <div class="col-md-6 ">
            <h1 class="sessionType2"><?= $overviewData[3] ['header'] ?></h1>
            <h4 class="DateAndTime2"><?= $overviewData[3] ['subHeader'] ?></h4>
            <p class="sessionDescription2"><?= $overviewData[3] ['text'] ?></p>
        </div>
    </div>
</div>

<div class="container desc1">
    <div class="row">
        <div class="col-md-6 ">
            <h1 class="sessionType3"><?= $overviewData[4] ['header'] ?></h1>
            <h4 class="DateAndTime3"><?= $overviewData[4] ['subHeader'] ?></h4>
            <p class="sessionDescription3"><?= $overviewData[4] ['text'] ?></p>
        </div>
        <div class="col-md-6 image-container">
            <img src="img/DanceEvent/<?= $overviewData[4] ['imageName'] ?>" alt="Your Image Description"
                 class="img-fluid image3">
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/DanceEvent/DanceMain.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>

