<?php
include __DIR__ . '/../header.php';

use App\Models\HistoryEntryTypeEnum;

// Group entries by page
$groupedEntries = [];
foreach ($entries as $entry) {
    // During each iteration, the current $entry is appended to array in $groupedEntries that corresponds to its page_name
    $groupedEntries[$entry->page_name][] = $entry;
}

?>
    <div class="admin-container">

        <div class="admin-panel">
            <h1>History Admin Panel</h1>
            <hr/>

            <div class="timeslots-section">
                <h2>Timeslots</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>English Tour</th>
                        <th>Dutch Tour</th>
                        <th>Chinese Tour</th>
                    </tr>
                    </thead>
                    <!-- (timeslot->getId()) -->
                    <tbody>
                    <?php foreach ($timeslots as $timeslot): ?>
                        <tr data-timeslot-id="<?= htmlspecialchars($timeslot['id']) ?>">
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['day']) ?></span>
                                <input class="edit" type="date" value="<?= htmlspecialchars($timeslot['day']) ?>"
                                       style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['start_time']) ?></span>
                                <input class="edit" type="time" value="<?= htmlspecialchars($timeslot['start_time']) ?>"
                                       style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['end_time']) ?></span>
                                <input class="edit" type="time" value="<?= htmlspecialchars($timeslot['end_time']) ?>"
                                       style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['english_tour']) ?></span>
                                <input class="edit" type="number"
                                       value="<?= htmlspecialchars($timeslot['english_tour']) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['dutch_tour']) ?></span>
                                <input class="edit" type="number"
                                       value="<?= htmlspecialchars($timeslot['dutch_tour']) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot['chinese_tour']) ?></span>
                                <input class="edit" type="number"
                                       value="<?= htmlspecialchars($timeslot['chinese_tour']) ?>" style="display:none;">
                            </td>
                            <td>
                                <button class="edit-btn" onclick="toggleEdit(this)">Edit</button>
                                <button class="save-btn" onclick="saveTimeslot(this)" style="display:none;">Save
                                </button>
                                <button class="delete-btn" onclick="deleteTimeslot(this)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

            <form action="/HistoryAdmin/addTimeslot" method="POST">
                <input type="date" name="day" required>
                <input type="time" name="start_time" required>
                <input type="time" name="end_time" required>
                <input type="number" name="english_tour" min="0" required>
                <input type="number" name="dutch_tour" min="0" required>
                <input type="number" name="chinese_tour" min="0" required>
                <button class="btn btn-success" type="submit">Add Timeslot</button>
            </form>

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
                                    <img src="<?= htmlspecialchars($entry->content) ?>"
                                         style="max-width: 200px; max-height: 200px;">
                                <?php else : ?>
                                    <div><?= $entry->content ?></div>
                                <?php endif; ?>
                                <textarea style="display: none;"><?= $entry->content ?></textarea>
                            </td>
                            <td class="action-buttons">
                                <button onclick="editEntry(<?= $entry->id ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <hr/>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="/js/adminViews/historyAdminActions.js" defer></script>

<?php include __DIR__ . '/../footer.php'; ?>