<?php
require __DIR__ . '/../header.php';

$events = $restaurant->getEvents();
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
        <p id="restaurant" style="display: none"><?php echo $restaurant->getId(); ?></p>
    </div>
</section>

<!--Restaurants cards-->
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
        </div>

        <!--form-->
        <div class="row align-items-center">
            <div class="col-md-2 text-left"></div>
            <div class="col-md-8 text-left">
                <div id="message" class="alert alert-api"></div>
                <form>
                    <div class="form-group">
                        <label for="daySelect">Choose a Day:</label>
                        <select id="daySelect" name="daySelect" class="form-control"
                                onchange="updateSessions(this.value)" required>
                            <option value="">Select a Day</option>
                            <?php
                            // Array to keep track of the days already displayed
                            $displayedDays = array();

                            foreach ($events as $event):
                                // Check if the event day has already been displayed
                                if (!in_array($event->getEventDay(), $displayedDays)) {
                                    // If not, display the event and add the day to the displayedDays array
                                    $displayedDays[] = $event->getEventDay();
                                    ?>
                                    <option value="<?php echo htmlspecialchars($event->getEventday()); ?>">
                                        <?php echo htmlspecialchars($event->getEventDay()); ?>
                                    </option>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <p></p>

                    <div class="form-group" id="sessionPicker" style="display: block;">
                        <label for="sessionSelect">Choose a Session:</label>
                        <select id="sessionSelect" name="sessionSelect" class="form-control" required>
                        </select>
                    </div>

                    <p></p>

                    <div class="row">
                        <div class="col-md-6 text-left">
                            <div class="form-group">
                                <label for="regularTickets">Regular Tickets:</label>
                                <input type="number" id="regularTickets" name="regularTickets" class="form-control"
                                       min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="form-group">
                                <label for="reducedTickets">Reduced Tickets:</label>
                                <input type="number" id="reducedTickets" name="reducedTickets" class="form-control"
                                       min="0" value="0" required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="mb-3">
                        <label for="specialRequests" class="form-label">Special requests:</label>
                        <textarea class="form-control" id="specialRequests" rows="3"></textarea>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <button type="button" class="btn btn-reserve" onclick="isLoggedIn()">Reserve</button>
                        </div>
                    </div>


                </form>
            </div>
            <div class="col-md-2 text-right"></div>
        </div>

    </div>
</div>

<script src="/js/Yummy/reservation.js"></script>

</body>


<?php
include __DIR__ . '/../footer.php';
?>