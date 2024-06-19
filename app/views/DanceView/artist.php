<?php include __DIR__ . '/../header.php'; ?>

    <div class="background-image">
        <div class="animated-text">Artists In the House</div>

    </div>

    <div class="container">
        <!-- Loop through your artists here -->
        <?php foreach ($artists as $index => $artist): ?>
            <div class="row">
                <!-- If the index is even, show the image first -->
                <?php if ($index % 2 == 0): ?>
                    <div class="col-md-6">
                        <img src="/img/DanceEvent/<?php echo $artist->getImageName(); ?>" class="img-fluid"
                             alt="<?php echo $artist->getHeader(); ?>">
                    </div>
                    <div class="col-md-6">
                        <p class="title"><?php echo $artist->getHeader(); ?></p>
                        <p class="subtitle"><?php echo html_entity_decode($artist->getSubHeader()); ?></p>
                        <p class="text"><?php echo html_entity_decode($artist->getText()); ?></p>
                    </div>
                    <!-- If the index is odd, show the text first -->
                <?php else: ?>
                    <div class="col-md-6 artist-text">
                        <p class="title"><?php echo $artist->getHeader(); ?></p>
                        <p class="subtitle"><?php echo html_entity_decode($artist->getSubHeader()); ?></p>
                        <p class="text"><?php echo html_entity_decode($artist->getText()); ?></p>
                    </div>
                    <div class="col-md-6">
                        <img src="/img/DanceEvent/<?php echo $artist->getImageName(); ?>" class="img-fluid"
                             alt="<?php echo $artist->getHeader(); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <!-- End of loop -->
    </div>
<?php include __DIR__ . '/../footer.php'; ?>