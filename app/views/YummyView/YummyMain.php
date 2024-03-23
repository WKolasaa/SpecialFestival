<?php 
    include __DIR__ . '/../header.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummy Homepage</title>
  <link rel="stylesheet" href="/css/YummyMain.css">
</head>
<body class="YummyBody">
    <section class="hero-section text-white text-center d-flex align-items-center justify-content-center">
        <div class="overlay">
            <h1 class="display-4">Explore Haarlem's Culinary Delights at</h1>
            <h2 class="display-2 font-weight-bold">Yummy</h2>
        </div>
     </section>

    <section class="header-section">
        <div class="header-content">
            <h2 class="date-range">25 July - 28 July</h2>
            <h1>Welcome to Yummy! Culinary Festival</h1>
            <p class="festival-description">Embark on a culinary adventure in Haarlem! From July 27-31, our city transforms into a food lover's paradise. Explore special Festival menus, reserve your table hassle-free, and savor chef-curated recipes. Join us in celebrating Haarlem's vibrant food culture — where every bite tells a story. Let the feast begin!</p>
        </div>
    </section>

    <div id="restaurantsCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card mb-3 mx-auto" style="max-width: 940px;">
                    <div class="row no-gutters">
                        <div class="container mt-4">
                            <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                <img src="/img/Yummy/CafeDeRoemer.jpeg" class="card-img-top" alt="Café de Roemer">
                                <div class="card-body">
                                    <h5 class="card-title">Café de Roemer</h5>
                                    <p class="card-text">Botermarkt 17, 2011 XL Haarlem</p>
                                    <p class="card-text"><small>Type: Dutch, fish and seafood, European</small></p>
                                    <p class="card-text">Price: € 35,00</p>
                                    <p class="card-text">Reduced: € 17,50</p>
                                    <p class="card-text">First Session: 18:00</p>
                                    <p class="card-text">Duration: 1.5h</p>
                                    <p class="card-text">Sessions: 3</p>
                                    <p class="card-text">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#restaurantsCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#restaurantsCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <div class="text-center my-4">
            <a href="/restaurants" class="btn btn-primary btn-lg">Check restaurants</a>
        </div>
    </div>

    <div class="contact-section">
        <div class="container">
            <h2>Contact us!</h2>
            <form class="contact-form">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="E-Mail">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Message" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-send">SEND</button>
            </form>
        </div>
    </div>

</body>
</html>

