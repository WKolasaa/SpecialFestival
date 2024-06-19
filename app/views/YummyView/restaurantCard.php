<div class="container my-5">
    <div class="card custom-border">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><?php echo htmlspecialchars($restaurant->getName()) ?></h2>
            </div>
        </div>
        <!--photos on top-->
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="/<?php echo htmlspecialchars($restaurant->getImagesByType('gallery')[0]->getImagePath()); ?>"
                         class="img-fluid full-height-img" alt="Restaurant Image">
                </div>
                <div class="col-md-6 text-center">
                    <div class="row g-2">
                        <?php
                        for ($i = 1; $i <= 4; $i++) {
                            echo '<div class="col-6">';
                            echo '<img src="/' . htmlspecialchars($restaurant->getImagesByType('gallery')[$i]->getImagePath()) . '" class="img-fluid img-fluid-cover" alt="Restaurant Image">';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <!--map and chef-->
        <div class="container text-center">
            <div class="row row-cols-2">
                <div class="col">
                    <img src="/<?php echo htmlspecialchars($restaurant->getImagesByType('map')[0]->getImagePath()) ?>"
                         class="img-fluid img-fluid-cover" alt="Map Image">
                </div>
                <div class="col">
                    <img src="/<?php echo htmlspecialchars($restaurant->getImagesByType('chef')[0]->getImagePath()) ?>"
                         class="img-fluid img-fluid-cover" alt="Chef Image">
                </div>
                <div class="col">
                    <p class="text-details"><?php echo htmlspecialchars($restaurant->getAddress()) ?></p>
                </div>
                <div class="col">
                    <p class="text-details">Chef <?php echo htmlspecialchars($restaurant->getChef()) ?></p>
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
                            if ($counter <= $restaurant->getStars()) {
                                echo '<span class="fa fa-star checked"></span>';
                            } else {
                                echo '<span class="fa fa-star"></span>';
                            }
                            $counter++;
                        }

                        ?>
                    </p>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-auto">
                    <a href="/RestaurantReservation?restaurantId=<?php echo $restaurant->getId(); ?>"
                       class="btn btn-reserve">Reserve</a>
                </div>
            </div>
        </div>
    </div>
</div>