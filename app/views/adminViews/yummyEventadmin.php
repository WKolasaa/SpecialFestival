<?php
    include __DIR__ . '/../header.php';
?>


<script src="/js/adminViews/YummyAdmin.js"></script>

<div class="col">
    <div class="row">
        <div class="parent-container">
            <div class="sidebar">
                <a href="#" onclick="showRestaurants()">Restaurants</a>
                <a href="#" onclick="showSessions()">Sessions</a>
                <a href="#" onclick="showImages()">Images</a>
                <a href="#" onclick="showReservations()">Reservations</a>
            </div>



            <div class="container mt-5">
                <h1 class="text-center mb-4">Restaurant CRUD</h1>
                <button id="sessionButton" class="btn btn-success">Add</button>

                <!-- Restaurant List -->
                <div id="restaurantsContainer">

                </div>

                <div id="editRestaurantContainer" style="display: none;">

                </div>

                <!--    Sessions-->
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div id="sessionContainer" style="display: none">
                                <h2 class="text-center">Sessions</h2>
                                <div class="form-group">
                                    <label for="restaurantList">Select Restaurant:</label>
                                    <select name="restaurantList" id="restaurantList" class="form-control" onchange="fetchRestaurantSessions(this.value)" required>
                                        <option value="0">Select Restaurant</option>
                                        <?php
                                        foreach ($restaurants as $restaurant) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($restaurant->getId()); ?>">
                                                <?php echo htmlspecialchars($restaurant->getName()); ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="sessions">

                            </div>
                        </div>
                    </div>
                </div>

                <!--    Images-->
                <div id="imagesContainer" style="display: none">
                    <div class="container mt-5">
                        <div class="card text-center">
                            <div class="card-body">
                                <h2 class="card-title mb-6">Upload Restaurant Images</h2>
                                <form>
                                    <div class="form-group">
                                        <label for="restaurantImages"><strong>Select Restaurant:</strong></label>
                                        <select id="restaurantImages" name="restaurantImages" class="form-control" onchange="displayImages(this.value)">
                                            <?php
                                            foreach ($restaurants as $restaurant) {
                                                echo '<option value="' . $restaurant->getId() . '">' . $restaurant->getName() . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <p></p>
                                    <div class="form-group">
                                        <label><strong>Upload Images:</strong></label>
                                        <div id="imageContainer">

                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" onclick="updateImages()">Update Images</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!--    Reservations-->
                <div id="reservationsContainer" style="Display: none">

                </div>

                <div id="addReservationContainer" style="Display: none">

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <p></p>
    </div>

    <div class="row">
        <?php
            include __DIR__ . '/../footer.php';
        ?>
    </div>

</div>




