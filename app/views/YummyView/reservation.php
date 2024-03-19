<?php
require __DIR__ . '/../header.php';
use App\Models\Restaurant;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy Restaurants</title>
    <link rel="stylesheet" href="/css/YummyMain.css">
    <style>

    </style>
</head>
<body class="YummyBody">
    <!--Top photo-->
    <section class="hero-section text-white text-center d-flex align-items-center justify-content-center">
        <div class="overlay">
            <h1 class="display-4">Check our participating</h1>
            <h2 class="display-2 font-weight-bold">Restaurants</h2>
        </div>
    </section>

    <!--Restaurants cards-->
    <div class="container my-5" >
        <div class="card custom-border">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><?php echo htmlspecialchars($restaurant->getName()) ?></h2>
                </div>
            </div>

            <!--photos on top-->
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="<?php echo htmlspecialchars($restaurant->getImages('gallery')[0]) ?>" class="img-fluid" alt="Restaurant Image">
                </div>
                <div class="col-md-6 text-center">
                    <div class="row row-cols-2">
                        <div class="col">
                            <img src="<?php echo htmlspecialchars($restaurant->getImages('gallery')[0]) ?>" class="img-fluid" alt="Restaurant Image">
                        </div>
                        <div class="col">
                            <img src="<?php echo htmlspecialchars($restaurant->getImages('gallery')[0]) ?>" class="img-fluid" alt="Restaurant Image">
                        </div>
                        <div class="col">
                            <img src="<?php echo htmlspecialchars($restaurant->getImages('gallery')[0]) ?>" class="img-fluid" alt="Restaurant Image">
                        </div>
                        <div class="col">
                            <img src="<?php echo htmlspecialchars($restaurant->getImages('gallery')[0]) ?>" class="img-fluid" alt="Restaurant Image">
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <!--map and chef-->
            <div class="container text-center">
                <div class="row row-cols-2">
                    <div class="col">
                        <img src="<?php echo htmlspecialchars($restaurant->getImages('map')) ?>" class="img-fluid" alt="Restaurant Image">
                    </div>
                    <div class="col">
                        <img src="<?php echo htmlspecialchars($restaurant->getImages('chef')) ?>" class="img-fluid" alt="Restaurant Image">
                    </div>
                    <div class="col">
                        <p><?php echo htmlspecialchars($restaurant->getAddress()) ?></p>
                    </div>
                    <div class="col">
                        <p>Chef <?php echo htmlspecialchars($restaurant->getChef()) ?></p>
                    </div>
                </div>
            </div>

            <!--datails-->
            <div class="row">
                <div class="col-8">
                    <div class="container text-left">
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($restaurant->getPhoneNumber()) ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($restaurant->getEmail()) ?></p>
                        <p><strong>Website:</strong> <?php echo htmlspecialchars($restaurant->getWebsite()) ?> </p>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($restaurant->getType()) ?> </p>
                    </div>
                </div>
                <div class="col-4 align-self-center">
                    <div class="container text-left">
                        <p class="card-text">
                            <?php
                            $counter = 1;
                            for ($x = 1; $x <= 5; $x++) {
                                if($counter <= $restaurant->getStars()){
                                    echo '<span class="fa fa-star checked"></span>';
                                } else{
                                    echo '<span class="fa fa-star"></span>';
                                }
                                $counter++;
                            }

                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!--form-->
            <form action="" method="">


            </form>

        </div>
    </div>
</body>
