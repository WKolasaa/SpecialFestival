<?php
if (!isset($_SESSION)) {
    session_start();
}
include __DIR__ . '/../header.php';
?>
<div class="container mt-5">
    <a class="text-dark" href="/PageManagement"><i class="fa-solid fa-angles-left text-dark"></i> Back</a>
    <h1><?= $pageTitle ?> Sections</h1>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><?= $section['sectionId'] ?></td>
                <td><?= $section['type'] ?></td>
                <td>
                    <a href="#" onclick="openEditorModal(<?= $section['sectionId']; ?>)"><i class="fa-solid fa-pen"></i></a>
                    <a class="ms-3"
                       href="/api/PageManagement/deleteSection?pageId=<?= $pageId; ?>&sectionId=<?= $section['sectionId']; ?>"><i
                                class="fa-solid fa-trash-can" style="color: red"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary float-end" onclick="openSectionModal()">Add Section</button>
</div>

<?php include __DIR__ . '/editSection.php'; ?>
<?php include __DIR__ . '/addSection.php'; ?>
<?php include __DIR__ . '/../foot.php'; ?>

<script>
    const pageId = <?= $_GET['pageId']; ?>;
</script>
<script src="/../js/CustomPages/listSection.js"></script>