<?php
include __DIR__ . '/../header.php';
?>

<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummy Homepage</title>
  <link rel="stylesheet" href="/css/YummyMain.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head> -->
<div class="YummyBody">
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
            <p class="festival-description">Embark on a culinary adventure in Haarlem! From July 27-31, our city
                transforms into a food lover's paradise. Explore special Festival menus, reserve your table hassle-free,
                and savor chef-curated recipes. Join us in celebrating Haarlem's vibrant food culture — where every bite
                tells a story. Let the feast begin!</p>
        </div>
    </section>

    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="true">
        <div class="carousel-indicators">
            <?php
            // Iterate over each restaurant and create carousel indicators
            foreach ($restaurants as $index => $restaurant) {
                $active = $index === 0 ? 'active' : '';
                echo '<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="' . $index . '" class="' . $active . '" aria-current="' . $active . '" aria-label="Slide ' . ($index + 1) . '"></button>';
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
            // Iterate over each restaurant and create carousel items
            foreach ($restaurants as $index => $restaurant) {
                $active = $index === 0 ? 'active' : '';
                echo '<div class="carousel-item ' . $active . '">';
                echo '<div class="card mb-3 mx-auto" style="max-width: 940px;">';
                echo '<div class="row no-gutters">';
                echo '<div class="container mt-4">';
                echo '<div class="card mb-3 mx-auto" style="max-width: 540px;">';
                echo '<img src="' . htmlspecialchars($restaurant->getImagesAsArray()[0]['imagePath']) . '" class="card-img-top" alt="' . htmlspecialchars($restaurant->getName()) . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($restaurant->getName()) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($restaurant->getAddress()) . '</p>';
                echo '<p class="card-text"><small>Type: ' . htmlspecialchars($restaurant->getType()) . '</small></p>';
                echo '<p class="card-text">Price: € ' . htmlspecialchars($restaurant->getPrice()) . '</p>';
                echo '<p class="card-text">Reduced: € ' . htmlspecialchars($restaurant->getReduced()) . '</p>';
                echo '<p class="card-text">First Session: ' . 1 . '</p>';
                echo '<p class="card-text">Duration: ' . 1 . '</p>';
                echo '<p class="card-text">Sessions: ' . 1 . '</p>';
                // Add more restaurant details as needed
                echo '<p class="card-text">';
                $counter = 1;
                for ($x = 1; $x <= 5; $x++) {
                    if ($counter <= $restaurant->getStars()) {
                        echo '<span class="fa fa-star checked"></span>';
                    } else {
                        echo '<span class="fa fa-star"></span>';
                    }
                    $counter++;
                }
                echo '</p>';
                // Close the card-body and card elements
                echo '</div></div></div></div></div></div>';
            }
            ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="text-center mt-4">
        <a href="/restaurants" class="btn btn-primary">View More Details</a>
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

</div>
<!-- </html> -->

<?php include __DIR__ . '/../footer.php'; ?>


    