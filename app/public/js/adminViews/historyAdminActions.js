function editEntry(entryId) {
    let entryRow = document.getElementById('entry-' + entryId);
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
                formData.append('entry_id', entryId);
                formData.append('image', fileInput.files[0]);

                fetch('/api/HistoryAdmin/updateImage', {
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
            formData.append('entry_id', entryId);
            formData.append('content', contentTextarea.value);

            fetch('/api/HistoryAdmin/update', {
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

function deleteEntry(entryId) {
    fetch(`/api/HistoryAdmin/delete?entry_id=${entryId}`)
        .then(() => document.getElementById(`entry-${entryId}`).remove())
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
        var directoryPath = 'img/History/';
        // Extract the file name
        var fileName = this.files[0].name;
        // Update the content input with the file name
        contentInput.value = directoryPath + fileName;
    }
});

function toggleEdit(button) {
    const tr = button.closest('tr');
    Array.from(tr.getElementsByClassName('view')).forEach(el => el.style.display = 'none');
    Array.from(tr.getElementsByClassName('edit')).forEach(el => el.style.display = '');
    tr.getElementsByClassName('edit-btn')[0].style.display = 'none';
    tr.getElementsByClassName('save-btn')[0].style.display = '';
}

function saveTimeslot(button) {
    const tr = button.closest('tr');
    const id = tr.getAttribute('data-timeslot-id');

    // Ensure selectors match your input names and structure
    const dayInput = tr.querySelector('input[type="date"]');
    const startTimeInput = tr.querySelectorAll('input[type="time"]')[0]; // Assuming this is the correct order
    const endTimeInput = tr.querySelectorAll('input[type="time"]')[1]; // Assuming this is the correct order
    const englishTourInput = tr.querySelectorAll('input[type="number"]')[0]; // Assuming this is the first number input
    const dutchTourInput = tr.querySelectorAll('input[type="number"]')[1]; // Adjust if order is different
    const chineseTourInput = tr.querySelectorAll('input[type="number"]')[2]; // Adjust if order is different

    if (!dayInput || !startTimeInput || !endTimeInput || !englishTourInput || !dutchTourInput || !chineseTourInput) {
        console.error('One or more inputs are missing in the DOM');
        return; // Stop execution if any input is not found
    }

    // Check for empty fields
    if (!dayInput.value.trim() || !startTimeInput.value.trim() || !endTimeInput.value.trim() ||
        !englishTourInput.value.trim() || !dutchTourInput.value.trim() || !chineseTourInput.value.trim()) {
        alert("Please fill in all the fields before saving.");
        return; // Stop execution if one of the fields is empty
    }

    // Check for negative numbers in tour fields
    if (englishTourInput.value < 0 || dutchTourInput.value < 0 || chineseTourInput.value < 0) {
        alert("Tour numbers cannot be negative. Please enter a valid number.");
        return; // Stop execution if one of the fields is negative
    }

    const data = {
        id: id,
        day: dayInput.value,
        start_time: startTimeInput.value,
        end_time: endTimeInput.value,
        english_tour: englishTourInput.value,
        dutch_tour: dutchTourInput.value,
        chinese_tour: chineseTourInput.value,
    };

    // Send the data to the server using fetch API
    fetch('/api/HistoryAdmin/updateTimeslot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update the view spans with new data
                const viewElements = tr.querySelectorAll('.view');
                const editInputs = tr.querySelectorAll('.edit');

                // Assuming the order of inputs and spans matches
                viewElements[0].textContent = editInputs[0].value; // day
                viewElements[1].textContent = editInputs[1].value; // start_time
                viewElements[2].textContent = editInputs[2].value; // end_time
                viewElements[3].textContent = editInputs[3].value; // english_tour
                viewElements[4].textContent = editInputs[4].value; // dutch_tour
                viewElements[5].textContent = editInputs[5].value; // chinese_tour

                // Toggle visibility
                editInputs.forEach(input => input.style.display = 'none');
                viewElements.forEach(span => span.style.display = '');

                // Toggle button visibility
                tr.querySelector('.edit-btn').style.display = '';
                tr.querySelector('.save-btn').style.display = 'none';
            } else {
                throw new Error('Failed to update timeslot');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
}

function deleteTimeslot(button) {
    const tr = button.closest('tr');
    const timeslotId = tr.getAttribute('data-timeslot-id');

    if (confirm("Are you sure you want to delete this timeslot?")) {
        fetch(`/api/HistoryAdmin/deleteTimeslot?id=${timeslotId}`, {
            method: 'GET'  // Or 'POST', if your server endpoint requires it
        })
            .then(response => {
                if (!response.ok) throw new Error('Failed to delete timeslot.');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    tr.remove();  // Remove the row from the table on successful deletion
                    showToast("Timeslot deleted successfully.", "#008000");
                } else {
                    throw new Error('Failed to delete timeslot: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error: " + error.message);
            });
    }
}




