<section class="container introduction col-10">
    <?php if ($section['heading'] ?? false): ?>
        <h2><?= $section['heading'] ?></h2>
        <?php if ($section['images'] ?? false):
            foreach ($section['images'] as $image): ?>
                <img src="<?= $image['imagePath'] ?>" alt="<?= $image['imageName'] ?>">
            <?php endforeach;
        endif; ?>
    <?php endif; ?>

    <?php if ($section['paragraphs'] ?? false): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p><?= $paragraph['text'] ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($section['linkText'] ?? false): ?>
        <a id="readMoreLink" href="#"><?= $section['linkText'] ?></a>
    <?php endif; ?>
</section>