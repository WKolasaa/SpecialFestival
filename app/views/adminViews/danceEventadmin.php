<?
include __DIR__ . '/../header.php';
?>
<div class="parent-container">
    <div class="sidebar">
        <a href="#" onclick="showArtists()">participators</a>
        <a href="#" onclick="showAgenda()">Agenda</a>
        <a href="#" onclick="showTickets()">Sessions</a>
        <a href="#" onclick="showOverview()">Overview</a>
    </div>

    <div class="main-container">
        <button id="add-btn" type="button" class="btn btn-success "></button>
        <div id="artists-container"></div>
        <div id="agenda-container"></div>
        <div id="tickets-container"></div>
        <div id="danceOverview-container" class="row"></div>

    </div>

    <div id="add-artist-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="add-artist-form" style="display:none;">
                <h3>Add New Artist</h3>
                <form id="artistForm" enctype="multipart/form-data" method="POST" class="p-3">
                    <div class="mb-3">
                        <label for="new-artist-name" class="form-label">Artist Name</label>
                        <input type="text" id="new-artist-name" name="artistName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-artist-style" class="form-label">Style</label>
                        <input type="text" id="new-artist-style" name="style" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-artist-description" class="form-label">Description</label>
                        <input type="text" id="new-artist-description" name="description" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-artist-title" class="form-label">Title</label>
                        <input type="text" id="new-artist-title" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-artist-date" class="form-label">Participation Date</label>
                        <!-- <select id="new-artist-date" name="participationDate" class="form-control" required>
                            <?php include __DIR__ . '/../../config/danceEventSchedule.php'; ?>
                        </select> -->
                        <select id="new-artist-date" name="participationDate" class="form-control" required>
                            <?php foreach ($dates as $date): ?>
                                <option value="<?= date('Y-m-d', strtotime($date)) ?>"><?= $date ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="new-artist-image" class="form-label">Image</label>
                        <input type="file" id="new-artist-image" name="image" class="form-control" accept="image/*"
                            required>
                    </div>
                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <div id="add-agenda-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="add-agenda-form" style="display:none;">
                <h3>Add New Event</h3>
                <div class="mb-3">
                    <label for="new-event-artistName" class="form-label">Artist Name</label>
                    <input type="text" id="new-event-artistName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-event-day" class="form-label">Event Day (e.g., Friday)</label>
                    <select id="new-event-day" class="form-control" required>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="new-event-date" class="form-label">Event Date</label>
                    <!-- <select id="new-event-date" class="form-control" required>
                    </select> -->
                    <?php include __DIR__ . '/../../config/danceEventSchedule.php'; ?>
                    <select id="new-event-date" class="form-control" required>
                        <?php foreach ($dates as $date): ?>
                            <option value="<?= date('Y-m-d', strtotime($date)) ?>"><?= $date ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="new-event-time" class="form-label">Event Time</label>
                    <input type="time" id="new-event-time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-event-duration" class="form-label">Duration (minutes)</label>
                    <input type="number" id="new-event-duration" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-event-ticketPrice" class="form-label">Ticket Price</label>
                    <input type="number" step="0.01" id="new-event-ticketPrice" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-event-ticketsAvailable" class="form-label">Tickets Available</label>
                    <input type="number" id="new-event-ticketsAvailable" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-event-venueAddress" class="form-label">Venue Address</label>
                    <input type="text" id="new-event-venueAddress" class="form-control" required>
                </div>
                <!-- <button class="btn btn-success" onclick="addEvent()">Submit</button> -->
                <button class="btn btn-success" onclick="if(validateAgendaForm()) { addEvent(); }">Submit</button>
            </div>
        </div>
    </div>

    <div id="add-ticket-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="add-ticket-form" style="display:none;">
                <h3>Add New Ticket</h3>
                <div class="mb-3">
                    <label for="new-ticket-artistName" class="form-label">Artist Name</label>
                    <input type="text" id="new-ticket-artistName" name="artistName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-startSession" class="form-label">Start Session</label>
                    <input type="time" id="new-ticket-startSession" name="startSession" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-endSession" class="form-label">End Session</label>
                    <input type="time" id="new-ticket-endSession" name="endSession" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-sessionDate" class="form-label">Session Date</label>
                    <!-- <select id="new-ticket-sessionDate" name="sessionDate" class="form-control" required>
                    </select> -->
                    <?php include __DIR__ . '/../../config/danceEventSchedule.php'; ?>
                    <select id="new-ticket-sessionDate" name="sessionDate" class="form-control" required>
                        <?php foreach ($dates as $date): ?>
                            <option value="<?= date('Y-m-d', strtotime($date)) ?>"><?= $date ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-venue" class="form-label">Venue</label>
                    <input type="text" id="new-ticket-venue" name="venue" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-price" class="form-label">Ticket Price</label>
                    <input type="number" step="0.01" id="new-ticket-price" name="ticketPrice" class="form-control"
                        required>
                </div>
                <div class="mb-3">
                    <label for="new-ticket-sessionType" class="form-label">Session Type</label>
                    <input type="text" id="new-ticket-sessionType" name="sessionType" class="form-control" required>
                </div>
                <!-- <button class="btn btn-success" onclick="addTicket()">Submit</button> -->
                <button class="btn btn-success" onclick="if(validateSessionForm()) { addTicket(); }">Submit</button>
            </div>
        </div>
    </div>

    <div id="add-overview-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="add-overview-form" style="display:none;">
                <h3>Add New Overview</h3>
                <form id="overviewForm" enctype="multipart/form-data" method="POST" class="p-3">
                    <div class="mb-3">
                        <label for="new-overview-header" class="form-label">header</label>
                        <input type="text" id="new-overview-header" name="header" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new-overview-subHeader" class="form-label">subHeader</label>
                        <input type="text" id="new-overview-subHeader" name="subHeader" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new-overview-text" class="form-label">Text</label>
                        <input type="text" id="new-overview-text" name="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-overview-image" class="form-label">Image</label>
                        <input type="file" id="new-overview-image" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="/js/adminViews/DanceEventInfo.js"></script>

<?
include __DIR__ . '/../footer.php';
?>