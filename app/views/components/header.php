<?php
function getColumnClass($num_images): string
{
    return match ($num_images) {
        1 => 'col-12',
        2 => 'col-6',
        default => 'col-4',
    };
}

function displaySectionContent($content): void
{
    if (!empty($content)) {
        echo $content;
    }
}

?>

<div class="header">
    <div class="row">
        <?php
        if (!empty($section['images'])):
            $col_class = getColumnClass(count($section['images']));

            foreach ($section['images'] as $image):?>
                <div class="<?= $col_class; ?> g-0 header-img">
                    <img class="img-fluid" src="<?= htmlspecialchars($image['imagePath']); ?>"
                         alt="<?= htmlspecialchars($image['imageName']); ?>" style="min-width: 100%;">
                </div>
            <?php endforeach; endif; ?>
    </div>
    <div class="col-8">
        <div class="container col-10">
            <?php displaySectionContent($section['heading']); ?>
            <?php displaySectionContent($section['subTitle']); ?>

            <?php if (!empty($section['paragraphs'])):
                foreach ($section['paragraphs'] as $paragraph):
                    displaySectionContent($paragraph['text']);
                endforeach; endif; ?>
        </div>
    </div>
</div>