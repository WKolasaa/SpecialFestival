<?php
if (!isset($_SESSION)) {
    session_start();
}
include __DIR__ . '/../header.php';
?>

<div class="container mt-5">
    <a class="text-dark" href="/PageManagement"><i class="fa-solid fa-angles-left text-dark"></i> Back</a>
    <h1>Create a new page</h1>
    <label class="form-label mt-3" for="pageTitleInput">Enter page title</label>
    <input class="form-control mt-1" type="text" name="pageTitleInput" id="pageTitleInput" required>
    <div id="containerSections">
        <div id="section1">
            <h2 class="mt-5">Section 1</h2>

            <label class="form-label mt-3" for="typeDropdown">Choose a section type</label>
            <select class="form-control mt-1" id="typeDropdown" name="typeDropdown" required>
            </select>

            <label class="form-label mt-3" for="textEditor1">Add text content</label>
            <textarea id="textEditor1"></textarea>

            <input class="form-control mt-3" type="file" name="images[]" id="imageInput" multiple>
        </div>
    </div>
    <button class="btn btn-primary mt-3 float-end" onclick="savePage()">Save page</button>
    <button class="btn btn-secondary m-3 float-end" onclick="addAnotherSection()">Add another section</button>
    <div id="message-container"></div>
</div>

<script src="https://cdn.tiny.cloud/1/jxxp173pvquef8fmhviuik8fzu8gtyya33sqkapg2d5kke7p/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script src="/../js/CustomPages/addPage.js"></script>