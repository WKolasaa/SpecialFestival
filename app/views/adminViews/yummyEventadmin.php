<?php
    include __DIR__ . '/../header.php';
?>

<script src="js/adminViews/YummyAdmin.js"></script>

<div class="parent-container">
    <div class="sidebar">
        <a href="#" onclick="showRestaurants()">Restaurants</a>
        <a href="#" onclick="showSessions()">Sessions</a>
        <a href="#" onclick="showImages()">Images</a>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Restaurant CRUD</h1>
        <button id="sessionButton" class="btn btn-success">Add</button>

        <!-- Restaurant List -->
        <div id="restaurantsContainer">
            <div class="card" id="restaurantsTable" style="display: block">
                <div class="card-header">Restaurant List</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Reduced</th>
                            <th>Stars</th>
                            <th class="table-actions align-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="restaurantList">
                        <!-- Restaurant records will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
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
                        <form method="POST" action="upload_images.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="restaurantImages"><strong>Select Restaurant:</strong></label>
                                <select id="restaurantImages" name="restaurantImages" class="form-control" onchange="updateImages(this.value)">
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
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                    <input type="file" name="restaurant_images[]" class="form-control-file mt-2" accept="image/*">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Update Images</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
    include __DIR__ . '/../footer.php';
?>

