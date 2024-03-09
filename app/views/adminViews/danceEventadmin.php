<?
include __DIR__ . '/../header.php';
?>
<div class="parent-container">
        <div class="sidebar">
            <a href="#" onclick="showArtists()">participators</a>
            <a href="#" onclick="showAgenda()">Agenda</a>
            <a href="#" onclick="showTickets()">Tickets</a>
    </div>

    <div class="main-container">
    <button id="add-btn" type="button" class="btn btn-success "></button>
            <div id="artists-container"></div>
            <div id="agenda-container"></div>
            <div id="tickets-container"></div>

            <div id="add-artist-form" style="display:none;">
            <h3>Add New Artist</h3>
            <input type="text" id="new-artist-name" placeholder="Artist Name">
            <input type="text" id="new-artist-style" placeholder="Style">
            <input type="date" id="new-artist-date" placeholder="Participation Date">
            <button onclick="addArtist()">Submit</button>
            </div>

            <div id="add-agenda-form" style="display:none;">
            <h3>Add New Event</h3>
            <input type="text" id="new-event-artistName" placeholder="Artist Name">
            <input type="text" id="new-event-day" placeholder="Event Day (e.g., Friday)">
            <input type="date" id="new-event-date" placeholder="Event Date">
            <input type="time" id="new-event-time" placeholder="Event Time">
            <input type="number" id="new-event-duration" placeholder="Duration (minutes)">
            <input type="number" step="0.01" id="new-event-ticketPrice" placeholder="Ticket Price">
            <input type="number" id="new-event-ticketsAvailable" placeholder="Tickets Available">
            <input type="text" id="new-event-venueAddress" placeholder="Venue Address">
            <button onclick="addEvent()">Submit</button>
            </div>


            <div id="add-ticket-form" style="display:none;">
            <h3>Add New Ticket</h3>
            <input type="text" id="new-ticket-artistName" placeholder="Artist Name">
            <input type="time" id="new-ticket-sessionTime" placeholder="Session Time">
            <input type="
            date" id="new-ticket-sessionDate" placeholder="Session Date">
            <input type="text" id="new-ticket-venue" placeholder="Venue">
            <input type="number" step="0.01" id="new-ticket-price" placeholder="Ticket Price">
            <button onclick="addTicket()">Submit</button>

</div>

    </div>
</div>
    
       

    <script src="js/adminViews/DanceEventInfo.js"></script>

<?
include __DIR__ . '/../footer.php';
?>