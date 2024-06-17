<div id="image-col" class="container col-4">
    <div class="row">
        <?php if(!empty($section['images'])):
        foreach ($section['images'] as $image): ?>
            <div class="col-6">
                <img src="<?= $image['imagePath']; ?>" alt="<?= $image['imageName']; ?>">
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
