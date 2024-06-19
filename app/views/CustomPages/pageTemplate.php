<?php
include __DIR__ . '/../header.php';

function includeSection($sections, $type): void
{
    foreach ($sections as $section) {
        if ($section['type'] === $type) {
            include __DIR__ . '/../components/' . $section['type'] . '.php';
        }
    }
}

?>

    <div>
        <?php includeSection($sections, 'header'); ?>
    </div>

    <div class="row">
        <div class="col-8">
            <?php
            includeSection($sections, 'section');
            ?>
        </div>

        <div class="col-4">
            <?php includeSection($sections, 'imageSection'); ?>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>