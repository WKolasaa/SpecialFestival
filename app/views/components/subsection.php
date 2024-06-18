<div class="container subsection col-10">
    <?php if ($section['heading'] ?? false): ?>
        <?= $section['heading'] ?>
    <?php endif; ?>

    <?php if ($section['paragraphs'] ?? false): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <?= $paragraph['text'] ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($section['linkText'] ?? false): ?>
        <a href="#" id="readLessLink"><?= $section['linkText'] ?></a>
    <?php endif; ?>
</div>