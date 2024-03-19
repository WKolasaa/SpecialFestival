<?php include __DIR__ . '/../header.php'; ?>

<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<video autoplay muted loop class="video-background">
  <source src="img/DanceEvent/IntroVideo.mp4" type="video/mp4">
</video>

<div class="container-fluid h-100">
  <div class="row h-100">
    <div class="col-6 d-flex align-items-end justify-content-start">
      <div class="text-white overlay-text festival-title">
        <h1>Move & Flow Festival</h1>
        <h2>HAARLEM</h2>
      </div>
    </div>
    <div class="col-6 d-flex align-items-end justify-content-end">
      <div class="text-white overlay-text festival-date text-center">
        <h3>July 26-28, 2024</h3>
        <hr class="golden-line">
        <p>Unleash the Beat, Move Your Feet</p>
        <p>Join the Dance Celebration!</p>
        <p>(Unforgettable Dance Experience)</p>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid text-center my-class d-flex flex-column justify-content-center align-items-center"
  style="height: 100vh;">
  <h1 class="countdown-title">Countdown <i class="far regular fa-hourglass"></i>
  </h1>
  <h2 class="countdown-subtitle">To Dance Festival!</h2>
  <div class="countdown-details">
    <p>Get ready to groove and have a blast with your family! We're counting down the days until the Family Dance
      Festival lights up Haarlem from July 26th to 28th. Don't miss the chance to join the fun – mark your calendars and
      get ready for a dance-filled family celebration.</p>
  </div>
  <div class="countdown-dates">
    July 26-28
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
      <h1 class="sessionType">BACK2BACK</h1>
      <h4 class="DateAndTime">Saturday 27,2024 14:00</h4>
      <p class="sessionDescription">Experience a Saturday like never before at Caprera Openluchttheater, featuring the incredible beats of Hardwell, the dynamic melodies of Martin Garrix, and the transcendent tunes of Armin van Buuren. It's a back-to-back dance extravaganza, lasting 540 minutes! Limited tickets available, so secure your spot for a day of music and memories. Tickets: €110.00.</p>
    </div>
    <div class="col-md-6 image-container">
      <img src="img/DanceEvent/Nicky Romero.jpeg" alt="Your Image Description" class="img-fluid image1">
      <img src="img/DanceEvent/Hardwell.jpeg" alt="Your Image Description" class="img-fluid image2">
      <img src="img/DanceEvent/Armin van buuren.jpeg" alt="Your Image Description" class="img-fluid image3">
    </div>
  </div>
</div>

<div class="container desc1">
  <div class="row">
    
    <div class="col-md-6 image-container">
      <img src="img/DanceEvent/Nicky Romero.jpeg" alt="Your Image Description" class="img-fluid image1">
      <img src="img/DanceEvent/Hardwell.jpeg" alt="Your Image Description" class="img-fluid image2">
      <img src="img/DanceEvent/Armin van buuren.jpeg" alt="Your Image Description" class="img-fluid image3">
    </div>
    <div class="col-md-6 ">
      <h1 class="sessionType">BACK2BACK</h1>
      <h4 class="DateAndTime">Saturday 27,2024 14:00</h4>
      <p class="sessionDescription">Experience a Saturday like never before at Caprera Openluchttheater, featuring the incredible beats of Hardwell, the dynamic melodies of Martin Garrix, and the transcendent tunes of Armin van Buuren. It's a back-to-back dance extravaganza, lasting 540 minutes! Limited tickets available, so secure your spot for a day of music and memories. Tickets: €110.00.</p>
    </div>
  </div>
</div>





    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <link rel="stylesheet"  href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
  <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/DanceEvent/DanceMain.js"></script>


<?php include __DIR__ . '/../footer.php'; ?>










<!-- 
<section class="section">
  <div class="swiper mySwiper container">
    <div class="swiper-wrapper content">
      <div class="swiper-slide card " data-artist-index="0">
     
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/martin2.jpeg" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span> </span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide card" data-artist-index="1">
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/Hardwell1.jpeg" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span></span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide card" data-artist-index="2">
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/Arrmin1.webp" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span></span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide card" data-artist-index="3">
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/afrojack1.jpeg" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span></span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide card" data-artist-index="4">
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/Tiesto-2.jpeg" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span></span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide card" data-artist-index="5">
        <div class="card-content">
          <div class="image">
            <img src="img/DanceEvent/images.jpeg" alt="Artists">
          </div>
          <div class="artist-container">
            <div class="artistDate">
              <span></span>
            </div>
            <div class="artistName">
              <span></span>
            </div>
            <div class="artistInfo">
              <span></span>
            </div>
            <div class="artistTitle">
              <span><span class="desc">Title:</span></span>
            </div>
            <div class="artistStyle">
              <span><span class="desc">Style:</span></span>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
  <div class="swiper-button-prev"></div>
<div class="swiper-button-next"></div>
</section> -->