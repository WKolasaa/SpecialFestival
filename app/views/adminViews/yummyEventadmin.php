<?php
    include __DIR__ . '/../header.php';
?>

<div class="parent-container">
    <div class="sidebar">
        <a href="#" onclick="showArtists()">Restaurants</a>
        <a href="#" onclick="showAgenda()">Sessions</a>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Restaurant CRUD</h1>

        <!-- Restaurant List -->
        <div class="card">
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
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Chef</th>
                        <th class="table-actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="restaurantList">
                    <!-- Restaurant records will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="js/adminViews/YummyAdmin.js"></script>

<?
    include __DIR__ . '/../footer.php';
?>

