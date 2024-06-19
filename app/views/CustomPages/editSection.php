<!DOCTYPE html>
<html lang="en">
<body>

<div class="modal fade" id="sectionEditorModal" tabindex="-1" aria-labelledby="sectionEditorModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionEditorModalLabel">Section Editor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="message-container-edit"></div>
                <textarea id="editor">
                        </textarea>
                <div id="image-div"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="saveContent()">Save changes</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://cdn.tiny.cloud/1/jxxp173pvquef8fmhviuik8fzu8gtyya33sqkapg2d5kke7p/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>