<div class="header">
    <div class="row">
        <?php
        if (!empty($section['images'])):
            $num_images = count($section['images']);
            $col_class = match ($num_images) {
                1 => 'col-12',
                2 => 'col-6',
                default => 'col-4',
            };

            foreach ($section['images'] as $image):?>
                <div class="<?php echo $col_class; ?> g-0 header-img">
                    <img class="img-fluid" src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>" style="min-width: 100%;">
                </div>
            <?php endforeach;
        endif; ?>
    </div>
    <div class="col-8">
        <div class="container col-10">
            <?php if(!empty($section['heading'])): ?>
                <?php echo($section['heading']); ?>
            <?php endif; ?>

            <?php if(!empty($section['subTitle'])): ?>
                <?php echo($section['subTitle']); ?>
            <?php endif; ?>

            <?php if(!empty($section['paragraphs'])):
                foreach ($section['paragraphs'] as $paragraph):?>
                <?php echo($paragraph['text']); ?>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

