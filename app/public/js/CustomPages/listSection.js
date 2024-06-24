let currentSectionId;

function openEditorModal(sectionId) {
    currentSectionId = sectionId;
    const myModal = new bootstrap.Modal(document.getElementById('sectionEditorModal'));
    tinymce.init({
        selector: 'textarea#editor',
        plugins: 'lists',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
    });

    fetch('/api/PageManagement/getSectionContent?sectionId=' + sectionId)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to fetch section content');
            }
        })
        .then(data => {
            let htmlContent = '';
            document.querySelector('#image-div').innerHTML = '';
            if (data.section.heading) {
                htmlContent += data.section.heading;
            }

            if (data.section.subTitle) {
                htmlContent += data.section.subTitle;
            }

            data.paragraphs.forEach(paragraph => {
                if (paragraph.text) {
                    htmlContent += paragraph.text;
                }
            });

            data.images.forEach(image => {
                const currentImage = document.createElement('img');
                currentImage.src = image.imagePath;
                currentImage.id = image.imageId;
                currentImage.style = 'max-width: 200px;';

                const imageUpload = document.createElement('input');
                imageUpload.type = 'file';
                imageUpload.accept = 'image/*';
                imageUpload.dataset.imageId = image.imageId;
                imageUpload.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    const imageId = event.target.dataset.imageId;
                    // Get the uploaded file
                    if (file) {
                        updateCurrentImage(imageId, URL.createObjectURL(file));
                    }
                })
                const imageEditor = document.createElement("form");
                imageEditor.appendChild(currentImage);
                imageEditor.appendChild(imageUpload);
                document.querySelector('#image-div').appendChild(imageEditor);
            });
            tinyMCE.activeEditor.setContent(htmlContent);
            myModal.show();
        })
        .catch(error => {
            console.error('Error fetching section content:', error);
        });
}

function updateCurrentImage(imageId, imagePath) {
    const currentImage = document.getElementById(imageId);
    if (currentImage) {
        currentImage.src = imagePath;
    }
}

function saveContent() {
    const newContent = tinyMCE.activeEditor.getContent("editor");
    const formData = new FormData();

    formData.append('sectionId', currentSectionId);
    formData.append('content', newContent);

    const imageFiles = document.querySelectorAll('input[type="file"]');
    imageFiles.forEach(fileInput => {
        const file = fileInput.files[0];
        const imageId = fileInput.dataset.imageId;
        if (file) {
            formData.append('images[' + imageId + ']', file);
        }
    });

    fetch('/api/PageManagement/updateContent', {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (response.ok) {
                const messageContainer = document.getElementById('message-container-edit');
                messageContainer.innerHTML = '<div class="alert alert-success mt-3">Changes were saved successfully.</div>';
                setTimeout(() => {
                    const activeModal = document.querySelector('.modal.show');
                    if (activeModal) {
                        const modalInstance = bootstrap.Modal.getInstance(activeModal);
                        modalInstance.hide();
                    }
                    messageContainer.innerHTML = '';
                }, 1000);
            } else {
                const messageContainer = document.getElementById('message-container-edit');
                messageContainer.innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
            }
        })
        .catch(error => {
            const messageContainer = document.getElementById('message-container-edit');
            messageContainer.innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
        });
}

function openSectionModal() {
    const myModal = new bootstrap.Modal(document.getElementById('sectionModal'));
    tinymce.init({
        selector: 'textarea#editorNewSection',
        plugins: 'lists',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
    });
    myModal.show();
}

function addSection() {
    const formData = new FormData();
    const sectionType = document.querySelector('select').value;
    const textEditorId = 'sectionModal';
    const sectionContent = tinyMCE.activeEditor.getContent("editorNewSection");
    formData.append(`section[pageId]`, pageId);
    formData.append(`section[sectionType]`, sectionType);
    formData.append(`section[content]`, sectionContent);

    const filesInput = document.querySelector('input[type="file"]');
    const files = filesInput.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        formData.append(`section[images][${i}]`, file);
    }
    const formDataObject = Object.fromEntries(formData);
    saveSection(formData);
}

function saveSection(formData) {
    fetch('/api/PageManagement/saveSection', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
            } else {
                document.getElementById('message-container').innerHTML = '<div class="alert alert-success mt-3">Changes were saved successfully.</div>';
            }
        })
        .catch(error => {
            document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
        })
}