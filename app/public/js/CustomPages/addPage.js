let numberOfSections = 1;
document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
    }
});

function initializeSection() {
    fetch('/api/PageManagement/getSectionTypes')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch section types');
            }
            return response.json();
        })
        .then(data => {
            const selectTypes = document.querySelectorAll('select[name="typeDropdown"]');
            selectTypes.forEach(selectType => {
                if (selectType.length === 0)
                    data.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type;
                        option.textContent = type;
                        selectType.appendChild(option);
                    });
            });
        })
        .catch(error => {
            console.error('Error fetching section types:', error);
        });

    tinymce.init({
        selector: 'textarea',
        plugins: 'lists',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
    });
}

window.addEventListener('DOMContentLoaded', initializeSection);

function addAnotherSection() {
    numberOfSections++;
    const container = document.querySelector('#containerSections');
    const lastSection = container.lastElementChild;
    const newSection = document.createElement('div');
    newSection.id = `section${numberOfSections}`;
    newSection.innerHTML = `
        <h2 class="mt-5">Section ${numberOfSections}</h2>
        <label class="form-label mt-3" for="typeDropdown${numberOfSections}">Choose a section type</label>
        <select class="form-control mt-1" id="typeDropdown${numberOfSections}" name="typeDropdown" required>
        </select>
        <label class="form-label mt-3" for="textEditor${numberOfSections}">Add text content</label>
        <textarea id="textEditor${numberOfSections}"></textarea>
        <input class="form-control mt-3" type="file" name="images[]" id="imageInput${numberOfSections}" multiple>
    `;
    container.appendChild(newSection);

    initializeSection();
}

function savePage() {
    const pageTitle = document.getElementById('pageTitleInput').value;
    if (!pageTitle || pageTitle.trim() === '') {
        document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Please enter a title for the page.</div>';
        return;
    }
    const sections = document.querySelectorAll('[id^=section]');
    const formData = new FormData();
    sections.forEach((section, index) => {
        const sectionType = section.querySelector('select').value;
        const textEditorId = `textEditor${index + 1}`;
        const sectionContent = tinymce.get(textEditorId).getContent();
        formData.append(`sections[${index}][sectionType]`, sectionType);
        formData.append(`sections[${index}][content]`, sectionContent);

        const filesInput = section.querySelector('input[type="file"]');
        const files = filesInput.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            formData.append(`sections[${index}][images][${i}]`, file);
        }
    })
    formData.append('pageTitle', pageTitle);
    saveToDatabase(formData);
}

function saveToDatabase(formData) {
    fetch('/api/PageManagement/savePage', {
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