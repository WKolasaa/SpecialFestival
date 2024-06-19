<div id="image-col" class="container">
    <div class="row">
        <?php if (!empty($section['images'])):
            foreach ($section['images'] as $image): ?>
                <div class="col-12">
                    <img src="<?= $image['imagePath']; ?>" alt="<?= $image['imageName']; ?>">
                </div>
            <?php endforeach; endif; ?>
    </div>
</div>