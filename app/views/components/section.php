<div class="container subsection col-10">
    <?php if ($section['paragraphs'] ?? false): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <?= $paragraph['text'] ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>