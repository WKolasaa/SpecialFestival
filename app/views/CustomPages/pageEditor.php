<?php
if (!isset($_SESSION)) {
    session_start();
}
include __DIR__ . '/../header.php';
?>
    <div class="container mt-5">
        <h1>Pages</h1>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?= $page['pageId'] ?></td>
                    <td><?= $page['pageTitle'] ?></td>
                    <td>
                        <a href="/PageManagement/sections?pageId=<?= $page['pageId']; ?>">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a class="ms-3" href="/PageManagement/showPage?pageId=<?= $page['pageId']; ?>">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="ms-3" href="/api/PageManagement/deletePage?pageId=<?= $page['pageId']; ?>">
                            <i class="fa-solid fa-trash-can" style="color: red"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-primary float-end" href="/PageManagement/addPage">Add page</a>
    </div>
<?php include __DIR__ . '/../foot.php'; ?>