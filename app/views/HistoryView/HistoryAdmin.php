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
    body, .admin-panel {
    position: relative; /* Ensures the admin panel can be a reference for absolute positioning */
    min-height: 100vh; /* Ensures the minimum height is the full viewport height */
    padding-bottom: 120px; /* Adjust based on the height of your form */
}

    .content-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
    }

    .content-table th,
    .content-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .content-table th:nth-child(3),
    .content-table td:nth-child(3) {
      width: 50%;
    }

    .content-table th {
        background-color: #f2f2f2;
    }

    .add-entry-form {
        position: fixed; /* Fixes the position relative to the viewport */
        bottom: 0; /* Anchors the form to the bottom of the viewport */
        left: 0;
        width: 100%; /* Ensures the form stretches across the width of the screen */
        background-color: white; /* Optional: makes the form stand out against the content */
        border-top: 1px solid #ddd; /* Optional: adds a border at the top of the form */
        padding: 20px; /* Optional: adds some padding inside the form */
        box-sizing: border-box; /* Ensures padding is included in the width calculation */
}

    .action-buttons {
        display: flex;
        align-items: center;
    }

    .action-buttons button {
      cursor: pointer;
      margin-right: 15px;
    }

    .editable-content {
        /* display: inline-block; */
        min-width: 200px;
    }

    .editable-content textarea {
        width: 100%;
        height: auto;
    }
    
</style>

<div class="admin-panel">
    <h1>History Admin Panel</h1>
    <hr />

    <?php foreach ($groupedEntries as $page => $pageEntries): ?>
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
                <?php foreach ($pageEntries as $entry): ?>
                    <tr id="entry-<?= $entry->id ?>">
                        <td><?= $entry->entry_name ?></td>
                        <td><?= $entry->entry_type == HistoryEntryTypeEnum::Text ? 'TEXT' : 'IMAGE' ?></td>
                        <td class="editable-content">
                            <div><?= $entry->content ?></div>
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
            <select name="entry_type">
                <option value="TEXT">Text</option>
                <option value="IMAGE">Image</option>
            </select>
        </label>

        <label>
            Entry Content:
            <input type="text" name="content" id="contentInput" value="" /> <!-- For text entries -->
            OR
            <input type="file" name="image" id="imageInput" accept="image/*"> <!-- For image uploads -->
        </label>

        <button type="submit">Add Entry</button>
    </form>
</div>

<script>
    function editEntry(entryId) {
        let entryRow = document.getElementById('entry-' + entryId);
        let contentCell = entryRow.querySelector('.editable-content');
        let contentContainer = contentCell.querySelector('div');
        let contentTextarea = contentCell.querySelector('textarea');
        let editButton = entryRow.querySelector('.action-buttons button:nth-of-type(1)');

        if (editButton.innerText === 'Edit') { //if buttons text is "Edit", clicking it will switch the view to edit mode 
            // Switch to edit mode
            contentContainer.style.display = 'none';
            contentTextarea.style.display = 'block'; //shows block around editable area
            contentTextarea.focus(); //makes the block blue color 
            editButton.innerText = 'Save'; //changing "edit" to "save" 
        } else if (editButton.innerText === 'Save') {
            // Save changes
            contentContainer.innerText = contentTextarea.value;
            contentContainer.style.display = 'inline-block';
            contentTextarea.style.display = 'none';
            editButton.innerText = 'Edit';

            // Execute fetch request to update content
            let formData = new FormData();
            formData.append('entry_id', entryId);
            formData.append('content', contentTextarea.value);

            fetch('/api/historyadmin/update', {
                method: 'POST',
                body: formData
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Failed to update entry!")
            });
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
