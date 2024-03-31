<?php include __DIR__ . '/../header.php'; ?>


<div class="ticket-selection-container">
    <h2 class="ticket-title">Regular ticket</h2>
    
    <!-- Days and Timeslots -->
    <div class="days-container">
        <?php
        // Example array for days and times
        $days = [
            'July 25' => ['10:00 - 12:30', '13:00 - 15:30', '16:00 - 18:30'],
            'July 26' => ['10:00 - 12:30', '13:00 - 15:30', '16:00 - 18:30'],
            'July 27' => ['10:00 - 12:30', '13:00 - 15:30', '16:00 - 18:30'],
            'July 28' => ['10:00 - 12:30', '13:00 - 15:30', '16:00 - 18:30']
        ];

        foreach ($days as $day => $timeslots) {
            echo "<div class='day-column'>";
            echo "<h3 class='day-name'>{$day}</h3>";
            foreach ($timeslots as $timeslot) {
                echo "<div class='timeslot'>";
                echo "<span class='timeslot-time'>{$timeslot}</span>";
                echo "<button class='add-to-cart'>ADD TO CART</button>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <!-- Language Selector and Ticket Options -->
    <div class="options-container">
        <div class="language-selector">
            <span>SELECT LANGUAGE</span>
            <select class="language-dropdown">
                <option value="en">English</option>
                <option value="zh">Chinese</option>
                <option value="nl">Dutch</option>
            </select>
        </div>
        <div class="tickets-options">
            <div class="regular-ticket-option">
                <img src="../img/icons/person-icon.png" alt="Regular Ticket Icon">
                <span>Regular Ticket:</span>
                <span>Price: €17,50</span>
                <span>Drink: 1</span>
            </div>
            <div class="family-ticket-option">
                <img src="../img/icons/family-icon.png" alt="Family Ticket Icon">
                <span>Family Ticket:</span>
                <span>Price: €60 (Max 4 people)</span>
                <span>Drink: 1 (per person)</span>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
