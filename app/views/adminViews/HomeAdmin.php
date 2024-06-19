<?php
include __DIR__ . '/../header.php'; 

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
                <tr id="entry-<?= htmlspecialchars($entry->getId()) ?>" data-entry-type="<?= htmlspecialchars($entry->getContentType()) ?>"> 
                    <td><?= htmlspecialchars($entry->getContentName()) ?></td>
                    <td><?= $entry->getContentType() == HistoryEntryTypeEnum::Text ? 'TEXT' : 'IMAGE' ?></td>
                    <td class="editable-content">
                        <?php if ($entry->getContentType() == HistoryEntryTypeEnum::Image): ?>
                            <img src="<?= htmlspecialchars($entry->getContent()) ?>" style="max-width: 200px; max-height: 200px;">
                        <?php else: ?>
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

    <h2>Event Calendar</h2>
    <table class="event-table">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr id="event-<?= htmlspecialchars($event->getId()) ?>">
                    <td><?= htmlspecialchars($event->getName()) ?></td>
                    <td><?= htmlspecialchars($event->getDescription()) ?></td>
                    <td><?= htmlspecialchars($event->getDate()) ?></td>
                    <td><?= htmlspecialchars($event->getStartTime()) ?></td>
                    <td><?= htmlspecialchars($event->getEndTime()) ?></td>
                    <td>
                        <button class="edit-button" onclick="editEvent(<?= htmlspecialchars($event->getId()) ?>)">Edit</button>
                        <button class="delete-button" data-event-id="<?= htmlspecialchars($event->getId()) ?>">Delete</button>                    
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form id="add-event-form" class="add-event-form">
        <label>
            Event Name:
            <input type="text" name="event_name" required />
        </label>

        <label>
            Description:
            <textarea name="event_description" required></textarea>
        </label>

        <label>
            Date:
            <input type="date" name="event_date" required />
        </label>    

        <label>
            Start Time:
            <input type="time" name="start_time" required />
        </label>

        <label>
            End Time:
            <input type="time" name="end_time" required />
        </label>

        <button type="submit">Add Event</button>
    </form>
</div>

<script src="/js/adminViews/homeAdminActions.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>
