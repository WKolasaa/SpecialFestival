function editEntry(id) {
    let entryRow = document.getElementById('entry-' + id);
    let entryType = entryRow.getAttribute('data-entry-type');
    let contentCell = entryRow.querySelector('.editable-content');
    // It's assumed that contentContainer can be a div or might not exist, hence the checks
    let contentContainer = contentCell.querySelector('div') ? contentCell.querySelector('div') : document.createElement('div');
    let contentTextarea = contentCell.querySelector('textarea');
    let editButton = entryRow.querySelector('.action-buttons button:nth-of-type(1)');
    let fileInput = contentCell.querySelector('input[type="file"]');
    let imagePreview = contentCell.querySelector('img');

    // Handle image entries
    if (!imagePreview) {
        imagePreview = document.createElement('img');
        imagePreview.style.maxWidth = '200px';
        imagePreview.style.maxHeight = '200px';
        contentCell.appendChild(imagePreview);
    }

    if (entryType === 'IMAGE') {
        if (editButton.innerText === 'Edit') {
            // Initialize or reset image upload and preview functionality
            if (!fileInput) {
                fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/*';
                fileInput.style.display = 'block'; // Show file input
                contentCell.appendChild(fileInput);
            } else {
                fileInput.style.display = 'block'; // Ensure file input is visible for a new edit
            }
            // Hide existing content and show file input
            contentContainer.style.display = 'none';
            imagePreview.style.display = 'none';
            editButton.innerText = 'Save';
        } else {
            // Attempt to save image changes
            if (fileInput && fileInput.files.length > 0) {
                let formData = new FormData();
                formData.append('id', id);// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                formData.append('image', fileInput.files[0]);

                fetch('/api/homeadmin/updateImage', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.headers.get("Content-Type").includes("application/json")) {
                        return response.json();
                    }
                    throw new Error('Received non-JSON response from the server');
                }).then(data => {
                    if (data.success) {
                        // Update the image preview with the new image
                        imagePreview.src = data.imageUrl; // Assuming 'imageUrl' is the key in your response
                        imagePreview.style.display = 'block';
                        fileInput.style.display = 'none'; // Hide file input
                        editButton.innerText = 'Edit'; // Reset button text
                        contentContainer.remove(); // Remove text container if it exists
                    } else {
                        throw new Error(data.message || "Failed to update image.");
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert("Failed to update entry: " + error.message);
                });
            }
        }
    } else {

        if (editButton.innerText === 'Edit') {
            // Switch to edit mode for text
            contentContainer.style.display = 'none';
            contentTextarea.style.display = 'block';
            contentTextarea.focus();
            editButton.innerText = 'Save';
        } else {
            // Attempt to save text changes
            let formData = new FormData();
            formData.append('id', id);
            formData.append('content', contentTextarea.value);

            fetch('/api/homeadmin/update', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    // If the HTTP status code does not indicate success, throw an error
                    throw new Error('Server responded with a non-ok status: ' + response.status);
                }
                return response.json(); // This will parse the JSON response body and return a promise
            }).then(data => {
                if (data.success) {
                    // Log the message to the console for debug purposes
                    console.log(data.message);
                    // Update the content on the page without reloading
                    contentContainer.innerText = contentTextarea.value;
                    contentContainer.style.display = 'inline-block';
                    contentTextarea.style.display = 'none';
                    // Reset the button text to "Edit" after saving
                    editButton.innerText = 'Edit';
                } else {
                    // Handle the case where `data.success` is false
                    console.error('Failed to update the content:', data.message);
                    alert("Failed to update entry: " + data.message);
                }
            }).catch(error => {
                // Catch and log any errors that occur during the fetch operation
                console.error('Error:', error);
                alert("Failed to update entry. Error: " + error.toString());
            });
        }

    }
}


function deleteEntry(id) {
    fetch(`/api/homeadmin/delete?id=${id}`)
        .then(() => document.getElementById(`entry-${id}`).remove())
        .catch((error) => {
            console.error(error);
            alert("Failed to remove entry!");
        })
}

document.addEventListener('DOMContentLoaded', function () {
    var entryTypeSelect = document.getElementById('entryTypeSelect');
    var contentInput = document.getElementById('contentInput');
    var imageInput = document.getElementById('imageInput');
    var entryContentLabel = document.getElementById('entryContentLabel');
    var entryContentInputs = document.getElementById('entryContentInputs');

    function toggleInputFields() {
        if (entryTypeSelect.value === 'TEXT') {
            entryContentLabel.style.display = ''; // Show the "Entry Content:" label
            contentInput.style.display = ''; // Show content input
            imageInput.style.display = 'none'; // Hide image input
        } else if (entryTypeSelect.value === 'IMAGE') {
            entryContentLabel.style.display = 'none'; // Hide the "Entry Content:" label
            contentInput.style.display = 'none'; // Hide content input
            imageInput.style.display = ''; // Show image input  
        }
    }

    // Initial check to set the correct state when the page loads
    toggleInputFields();

    // Event listener for when the entry type changes
    entryTypeSelect.addEventListener('change', function () {
        toggleInputFields();
    });
});

document.getElementById('imageInput').addEventListener('change', function () {
    var fileInput = this;
    var contentInput = document.getElementById('contentInput');

    if (fileInput.files && fileInput.files[0]) {
        // Specify the directory path where the file will be stored
        var directoryPath = 'img/Home/';
        // Extract the file name
        var fileName = this.files[0].name;
        // Update the content input with the file name
        contentInput.value = directoryPath + fileName;
    }
});
