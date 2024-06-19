document.addEventListener('DOMContentLoaded', function() {
    // This function runs when the DOM is fully loaded

    const entryTypeSelect = document.getElementById('entryTypeSelect');
    const contentInput = document.getElementById('contentInput');
    const imageInput = document.getElementById('imageInput');
    const entryContentLabel = document.getElementById('entryContentLabel');

    // Function to toggle between content input and image input based on entry type selection
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

    if (entryTypeSelect) {
        // Initial check to set the correct state when the page loads
        toggleInputFields();
        // Event listener for when the entry type changes
        entryTypeSelect.addEventListener('change', toggleInputFields);
    }

    // Add event listeners only once for the event table
    const eventTable = document.querySelector('.event-table');
    if (eventTable) {
        eventTable.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit-button')) {
                const eventId = target.closest('tr').id.replace('event-', '');
                editEvent(eventId);
            } else if (target.classList.contains('delete-button')) {
                const eventId = target.closest('tr').id.replace('event-', '');
                deleteEvent(eventId);
            }
        });
    }

    // Add event listener for the add event form
    const addEventForm = document.getElementById('add-event-form');
    if (addEventForm) {
        addEventForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(addEventForm);

            fetch('/api/HomeAdmin/addEvent', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    //alert(data.message);
                    // Add new event to the table without reloading the page
                    const newRow = document.createElement('tr');
                    newRow.id = 'event-' + data.eventId; 
                    newRow.innerHTML = `
                        <td>${formData.get('event_name')}</td>
                        <td>${formData.get('event_description')}</td>
                        <td>${formData.get('event_date')}</td>
                        <td>${formData.get('start_time')}</td>
                        <td>${formData.get('end_time')}</td>
                        <td>
                            <button class="edit-button" onclick="editEvent(${data.eventId})">Edit</button>
                            <button class="delete-button" onclick="deleteEvent(${data.eventId})">Delete</button>
                        </td>
                    `;
                    document.querySelector('.event-table tbody').appendChild(newRow);
                    addEventForm.reset(); // Reset form after successful addition
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add event. Error: ' + error.message);
            });
        });
    }

    // Handle image input change for content
    if (imageInput) {
        imageInput.addEventListener('change', handleImageInputChange);
    }
});

// This function updates the content input field with the path of the selected image file when the image input changes
function handleImageInputChange() {
    const fileInput = this;
    const contentInput = document.getElementById('contentInput');

    if (fileInput.files && fileInput.files[0]) {
        const directoryPath = 'img/Home/';
        const fileName = this.files[0].name;
        contentInput.value = directoryPath + fileName;
    }
}

// Handles the editing of entries. It allows the user to edit either text or image entries and updates the server with the new content
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
                formData.append('id', id);
                formData.append('image', fileInput.files[0]);

                fetch('/api/HomeAdmin/updateImage', {
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

            fetch('/api/HomeAdmin/update', {
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

// Confirms the deletion of an event, then sends a request to the server to delete the event. If successful, it removes the event row from the DOM.
function deleteEvent(eventId) {
        fetch(`/api/HomeAdmin/deleteEvent?id=${eventId}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the event from the DOM
                const eventRow = document.getElementById(`event-${eventId}`);
                if (eventRow) {
                    eventRow.remove();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error deleting event: " + error.message);
        });
}

// Prepares the event row for editing by replacing the current content with input fields
function editEvent(eventId) {
    const tr = document.getElementById(`event-${eventId}`);
    if (!tr) {
        console.error('No table row found for the given ID');
        return;
    }

    const editables = tr.querySelectorAll('td:not(:last-child)');
    editables.forEach((td, index) => {
        const inputType = (index === 2) ? 'date' : (index > 2 ? 'time' : 'text');
        const input = createInput(inputType, td.innerText);
        td.innerHTML = '';
        td.appendChild(input);
    });

    const actionCell = tr.querySelector('td:last-child');
    if (actionCell) {
        actionCell.innerHTML = createSaveCancelButton(eventId);
    } else {
        console.error('No actions cell found');
    }
}

// Creates and returns an input element of the specified type and value. Used in editEvent function.
function createInput(type, value) {
    const input = document.createElement('input');
    input.type = type;
    input.value = value;
    return input;
}

// Creates and returns the HTML for the Save and Delete buttons for event editing. Used in editEvent function.
function createSaveCancelButton(eventId) {
    return `<button onclick="saveEvent(${eventId})">Save</button>
            <button onclick="deleteEvent(${eventId})">Delete</button>`;
}

// Saves the edited event by sending a request to the server with the updated event data. If successful, it updates the table row with the new data
function saveEvent(eventId) {
    const tr = document.getElementById(`event-${eventId}`);
    const inputs = tr.querySelectorAll('input');
    const data = {
        id: eventId,
        name: inputs[0].value,
        description: inputs[1].value,
        date: inputs[2].value,
        startTime: inputs[3].value,
        endTime: inputs[4].value
    };

    fetch('/api/HomeAdmin/updateEvent', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            inputs.forEach((input, index) => {
                const td = input.parentElement;
                td.innerText = input.value;
            });
            const actionCell = tr.querySelector('td:last-child');
            actionCell.innerHTML = `<button onclick="editEvent(${eventId})">Edit</button><button onclick="deleteEvent(${eventId})">Delete</button>`;
        } else {
            alert('Failed to update event.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating event.');
    });
}
