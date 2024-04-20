<?php 
include __DIR__ . '/../header.php';
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummy Restaurants</title>
  <link rel="stylesheet" href="/css/YummyMain.css">
  <style>

  </style>
</head> -->
<div class="YummyBody">
    <!--Top photo-->
    <section class="hero-section text-white text-center d-flex align-items-center justify-content-center">
        <div class="overlay">
            <h1 class="display-4">Check our participating</h1>
            <h2 class="display-2 font-weight-bold">Restaurants</h2>
        </div>
    </section>

    <!--Restaurants cards-->
    <?php
        foreach ($restaurants as $restaurant) {
             include __DIR__ . '/restaurantCard.php'; // The problem in this line cause when I comment it, the navbar works
        }
    ?>

</div>


<?php include __DIR__ . '/../footer.php'; ?>
