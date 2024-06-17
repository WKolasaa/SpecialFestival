<?php
include __DIR__ . '/../header.php';

use App\Models\HistoryEntryTypeEnum;

// Group entries by page
$groupedEntries = [];
foreach ($entries as $entry) {
    $groupedEntries[$entry->getPageName()][] = $entry;
}

?>
<div class="admin-container">

    <div class="admin-panel">
        <h1>History Admin Panel</h1>
        <hr />

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
                <tbody>
                    <?php foreach ($timeslots as $timeslot): ?>
                        <tr data-timeslot-id="<?= htmlspecialchars($timeslot->getId()) ?>"> 
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getDay()) ?></span>
                                <input class="edit" type="date" value="<?= htmlspecialchars($timeslot->getDay()) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getStartTime()) ?></span>
                                <input class="edit" type="time" value="<?= htmlspecialchars($timeslot->getStartTime()) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getEndTime()) ?></span>
                                <input class="edit" type="time" value="<?= htmlspecialchars($timeslot->getEndTime()) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getEnglishTour()) ?></span>
                                <input class="edit" type="number" value="<?= htmlspecialchars($timeslot->getEnglishTour()) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getDutchTour()) ?></span>
                                <input class="edit" type="number" value="<?= htmlspecialchars($timeslot->getDutchTour()) ?>" style="display:none;">
                            </td>
                            <td>
                                <span class="view"><?= htmlspecialchars($timeslot->getChineseTour()) ?></span>
                                <input class="edit" type="number" value="<?= htmlspecialchars($timeslot->getChineseTour()) ?>" style="display:none;">
                            </td>
                            <td>
                                <button class="edit-btn" onclick="toggleEdit(this)">Edit</button>
                                <button class="save-btn" onclick="saveTimeslot(this)" style="display:none;">Save</button>
                                <button class="delete-btn" onclick="deleteTimeslot(this)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <form action="/historyAdmin/addTimeslot" method="POST">
            <input type="date" name="day" required>
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <input type="number" name="english_tour" min="0" required>
            <input type="number" name="dutch_tour" min="0" required>
            <input type="number" name="chinese_tour" min="0" required>
            <button class="btn btn-success" type="submit">Add Timeslot</button>
        </form>

        <?php foreach ($groupedEntries as $page => $pageEntries) : ?>
            <h2><?= htmlspecialchars($page) ?></h2>
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
                        <tr id="entry-<?= htmlspecialchars($entry->getId()) ?>" data-entry-type="<?= htmlspecialchars($entry->getEntryType()) ?>">
                            <td><?= htmlspecialchars($entry->getEntryName()) ?></td>
                            <td><?= $entry->getEntryType() == HistoryEntryTypeEnum::Text ? 'TEXT' : 'IMAGE' ?></td>
                            <td class="editable-content">
                                <?php if ($entry->getEntryType() == HistoryEntryTypeEnum::Image) : ?>
                                    <!-- Show image preview -->
                                    <img src="<?= htmlspecialchars($entry->getContent()) ?>" style="max-width: 200px; max-height: 200px;">
                                <?php else : ?>
                                    <div><?= htmlspecialchars($entry->getContent()) ?></div>
                                <?php endif; ?>
                                <textarea style="display: none;"><?= htmlspecialchars($entry->getContent()) ?></textarea>
                            </td>
                            <td class="action-buttons">
                                <button onclick="editEntry(<?= htmlspecialchars($entry->getId()) ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr />
        <?php endforeach; ?>
    </div>
</div>
<script src="/js/adminViews/historyAdminActions.js" defer></script>

<?php include __DIR__ . '/../footer.php'; ?>
