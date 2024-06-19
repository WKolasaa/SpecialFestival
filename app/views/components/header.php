<div class="header">
    <div class="col-8">
        <div class="container col-10">
            <?php if (!empty($section['paragraphs'])):
                foreach ($section['paragraphs'] as $paragraph):
                    echo $paragraph['text'];
                endforeach; endif; ?>
        </div>
    </div>
</div>