<?php
include __DIR__ . '/../header.php';

use App\Models\HistoryEntryTypeEnum;
use App\Models\UserRolesEnum;
use App\Services\HistoryAdminService;

// Check user role
if (!isset($_SESSION['user']) || $_SESSION['user']->getUserRole() !== UserRolesEnum::Administrator) {
    http_response_code(403);
    echo "Forbidden 403.";
    exit();
}

// Fetch history entries
$service = new HistoryAdminService();
$entries = $service->getAll();

// Group entries by page
$groupedEntries = [];
foreach ($entries as $entry) {
    $groupedEntries[$entry->page_name][] = $entry;
}

?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');

    body,
    .admin-panel {
        font-family: 'Open Sans', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        padding-bottom: 120px;
        /* Space for the fixed form */
    }

    .admin-panel {
        padding: 20px;
        margin: 0;
    }

    h1,
    h2 {
        color: #0056b3;
    }

    .content-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .content-table th,
    .content-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .content-table th {
        background-color: #009879;
        color: #ffffff;
        font-weight: 600;
    }

    .content-table tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .content-table tr:hover {
        background-color: #f2f2f2;
        cursor: default;
    }

    .add-entry-form {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f9f9f9;
        padding: 10px;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        display: flex;
        flex-direction: row;
        /* Align items left to right */
        align-items: center;
        /* Center items vertically */
        gap: 10px;
        /* Space between elements */
        z-index: 1000;
    }

    .add-entry-form label {
        margin: 0;
        flex-grow: 1;
        /* Allow each field to grow */
    }

    .add-entry-form input,
    .add-entry-form select,
    .add-entry-form button {
        padding: 8px;
        margin: 0;
        /* Remove default margin */
        border-radius: 5px;
        border: 1px solid #ddd;
        flex-grow: 1;
        /* Allow each input/button to grow */
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        /* Aligns children (buttons) vertically */
        align-items: center;
        /* Centers buttons horizontally within the container */
        gap: 5px;
        /* Space between buttons */
    }

    .action-buttons button {
        background-color: #28a745;
        /* Green background */
        color: white;
        padding: 8px 15px;
        /* Uniform padding */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 90px;
        /* Fixed width for uniformity */
        height: 38px;
        /* Fixed height for uniformity */
        /* Removed margin-bottom as gap property is now being used for spacing */
    }

    /* Remove the bottom margin from the last button to avoid extra space at the end */
    .action-buttons button:last-child {
        margin-bottom: 0;
    }

    .action-buttons button:hover {
        background-color: #218838;
        /* Darker green on hover */
    }

    .editable-content textarea {
        width: 100%;
        /* Full width of its parent container */
        height: 100%;
        /* Full height of its parent container */
        box-sizing: border-box;
        /* Includes padding and border in the element's size */
        display: none;
        /* Initially hidden */
    }
</style>



<div class="admin-panel">
    <h1>History Admin Panel</h1>
    <hr />

    <?php foreach ($groupedEntries as $page => $pageEntries) : ?>
        <h2><?= $page ?></h2>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pageEntries as $entry) : ?>
                    <tr id="entry-<?= $entry->id ?>" data-entry-type="<?= $entry->entry_type ?>">
                        <td><?= $entry->entry_name ?></td>
                        <td><?= $entry->entry_type == HistoryEntryTypeEnum::Text ? 'TEXT' : 'IMAGE' ?></td>
                        <td class="editable-content">
                            <?php if ($entry->entry_type == HistoryEntryTypeEnum::Image) : ?>
                                <!-- Show image preview -->
                                <img src="<?= htmlspecialchars($entry->content) ?>" style="max-width: 200px; max-height: 200px;">
                            <?php else : ?>
                                <div><?= $entry->content ?></div>
                            <?php endif; ?>
                            <textarea style="display: none;"><?= $entry->content ?></textarea>
                        </td>
                        <td class="action-buttons">
                            <button onclick="editEntry(<?= $entry->id ?>)">Edit</button>
                            <button onclick="deleteEntry(<?= $entry->id ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr />
    <?php endforeach; ?>

    <form action="/HistoryAdmin/addEntry" method="POST" class="add-entry-form" enctype="multipart/form-data">
        <label>
            Page:
            <select name="page_name">
                <option value="History Main">History Main</option>
                <option value="History Port">History Port</option>
                <option value="History Windmill">History Windmill</option>
            </select>
        </label>

        <label>
            Entry Name:
            <input name="entry_name" value="" />
        </label>

        <label>
            Entry Type:
            <select name="entry_type" id="entryTypeSelect">
                <option value="TEXT">Text</option>
                <option value="IMAGE">Image</option>
            </select>
        </label>

        <!-- Separated Entry Content Label -->
        <div id="entryContentLabel" style="flex-grow: 1;">
            Entry Content:
        </div>

        <!-- Entry Content Inputs -->
        <label id="entryContentInputs">
            <input type="text" name="content" id="contentInput" value="" /> <!-- For text entries -->
            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;"> <!-- For image uploads, initially hidden -->
        </label>

        <button type="submit">Add Entry</button>
    </form>
</div>

<script>
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

                    fetch('/api/historyadmin/updateImage', {
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
            // Handle text entries
            // if (editButton.innerText === 'Edit') {
            //     // Switch to edit mode for text
            //     contentContainer.style.display = 'none';
            //     contentTextarea.style.display = 'block';
            //     contentTextarea.focus();
            //     editButton.innerText = 'Save';
            // } else {
            //     // Attempt to save text changes
            //     let formData = new FormData();
            //     formData.append('entry_id', entryId);
            //     formData.append('content', contentTextarea.value);

            //     fetch('/api/historyadmin/update', {
            //         method: 'POST',
            //         body: formData
            //     }).then(response => {
            //         if (response.ok) {
            //             return response.json(); // Process it as JSON only if response was ok
            //         } else {
            //             throw new Error('Server responded with a non-ok status: ' + response.status);
            //         }
            //     }).then(text => {
            //         try {
            //             return JSON.parse(text);
            //         } catch (e) {
            //             throw new Error('Failed to parse JSON response: ' + e.message);
            //         }
            //     }).then(data => {
            //         if (data.success) {
            //             console.log(data.message);
            //             contentContainer.innerText = contentTextarea.value;
            //             contentContainer.style.display = 'inline-block';
            //             contentTextarea.style.display = 'none';
            //             editButton.innerText = 'Edit';
            //         } else {
            //             console.error('Failed to update the content:', data.message);
            //             alert("Failed to update entry: " + data.message);
            //         }
            //     }).catch(error => {
            //         console.error('Error:', error);
            //         alert("Failed to update entry. Error: " + error.toString());
            //     });
            // }

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

                fetch('/api/historyadmin/update', {
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
        fetch(`/api/historyadmin/delete?entry_id=${entryId}`)
            .then(() => document.getElementById(`entry-${entryId}`).remove())
            .catch((error) => {
                console.error(error);
                alert("Failed to remove entry!");
            })
    }

    document.addEventListener('DOMContentLoaded', function() {
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
        entryTypeSelect.addEventListener('change', function() {
            toggleInputFields();
        });
    });
</script>

<script>
    document.getElementById('imageInput').addEventListener('change', function() {
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
</script>


<?php include __DIR__ . '/../footer.php'; ?>