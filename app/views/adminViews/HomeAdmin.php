<?php
include __DIR__ . '/../header.php'; // Adjust the path as necessary

use App\Models\HistoryEntryTypeEnum;

?>

<div class="admin-panel">
    <h1>Home Content Admin Panel</h1>
    <hr />

    <table class="content-table">
        <thead>
            <tr>
                <th>Content Name</th>
                <th>Type</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry) : ?>
                <tr id="entry-<?= $entry->id ?>" data-entry-type="<?= $entry->content_type ?>"> 
                    <td><?= htmlspecialchars($entry->content_name) ?></td>
                    <td><?= $entry->content_type == HistoryEntryTypeEnum::Text ? 'TEXT' : 'IMAGE' ?></td>
                    <td class="editable-content">
                        <?php if ($entry->content_type == HistoryEntryTypeEnum::Image): ?>
                            <!-- Show image preview -->
                            <img src="<?= htmlspecialchars($entry->content) ?>" style="max-width: 200px; max-height: 200px;">
                        <?php else: ?>
                            <!-- For TEXT content, simply display it within a div -->
                            <div><?= $entry->content ?></div>
                        <?php endif; ?>
                        <!-- Hidden textarea for edit mode -->
                        <textarea style="display: none;"><?= htmlspecialchars($entry->content) ?></textarea>
                    </td>
                    <td class="action-buttons">
                        <!-- Adjust the onclick functions to your corresponding JavaScript functions for editing and deleting -->
                        <button onclick="editEntry(<?= $entry->id ?>)">Edit</button>
                        <button onclick="deleteEntry(<?= $entry->id ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="/HomeAdmin/addEntry" method="POST" class="add-entry-form" enctype="multipart/form-data">
        <label>
            Content Name:
            <input name="content_name" value="" />
        </label>

        <label>
            Content Type:
            <select name="content_type" id="entryTypeSelect">
                <option value="TEXT">Text</option>
                <option value="IMAGE">Image</option>
            </select>
        </label>

        <!-- Separated Entry Content Label -->
        <div id="entryContentLabel" style="flex-grow: 1;">
            Content:
        </div>

        <!-- Entry Content Inputs -->
        <label id="entryContentInputs">
            <input type="text" name="content" id="contentInput" value="" /> <!-- For text entries -->
            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;"> 
        </label>


        <button type="submit">Add Content</button>
    </form>

</div>

<script src="/js/adminViews/homeAdminActions.js"></script> <!-- Adjust the path as necessary -->

<?php include __DIR__ . '/../footer.php'; ?>
