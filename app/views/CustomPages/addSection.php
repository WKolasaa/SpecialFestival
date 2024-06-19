<!DOCTYPE html>
<html lang="en">
<body>
<div class="modal fade" id="sectionModal" tabindex="-1" aria-labelledby="sectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionModalLabel">Add Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="message-container"></div>
                <label class="form-label" for="typeSelector">Choose the type of section: </label>
                <select class="form-control mb-3" name="typeSelector" id="typeSelector" required></select>

                <textarea id="editorNewSection"></textarea>
                <div id="imageDiv">
                    <input class="form-control mt-3" type="file" name="images[]" id="imageInput" multiple>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="addSection()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/jxxp173pvquef8fmhviuik8fzu8gtyya33sqkapg2d5kke7p/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script src="/../js/CustomPages/addSection.js"></script>
</body>
</html>