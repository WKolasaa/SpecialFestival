<?php
include __DIR__ . '/../header.php';

use App\Models\HistoryEntryTypeEnum;

// Group entries by page
$groupedEntries = [];
foreach ($entries as $entry) {
    $groupedEntries[$entry->page_name][] = $entry;
}

?>

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
            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;"> 
        </label>

        <button type="submit">Add Entry</button>
    </form>
</div>

<script src="/js/adminViews/historyAdminActions.js" defer></script>

<?php include __DIR__ . '/../footer.php'; ?>