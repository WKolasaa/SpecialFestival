<?php include __DIR__ . '/../header.php'; ?>


<div class="ticket-selection-container">
   
    <!-- Timeslots Section -->
    <div class="timeslots-section">
        <h2 class="timeslots-title">Timeslots</h2>
        <?php
        $timeslots = $service->getAllTimeslots(); // Fetch timeslots from the service
        foreach ($timeslots as $timeslot):
            // Convert the 'day' from Y-m-d to a more readable format
            $formattedDate = date("F j, l", strtotime($timeslot['day']));
        ?>
            <div class="timeslot" data-timeslot-id="<?= $timeslot['id'] ?>">
                <h3>Date: <?= htmlspecialchars($formattedDate) ?></h3>
                <p><strong>Time:</strong> <?= htmlspecialchars($timeslot['start_time']) ?> - <?= htmlspecialchars($timeslot['end_time']) ?></p>
                <div>
                    <strong>Ticket Type:</strong>
                    <label><input type="radio" name="ticketType_<?= $timeslot['id'] ?>" value="Regular" class="ticket-type"> Regular Ticket</label>
                    <label><input type="radio" name="ticketType_<?= $timeslot['id'] ?>" value="Family" class="ticket-type"> Family Ticket</label>
                </div>
                <div>
                    <strong>Language:</strong>
                    <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="English" class="language"> English</label>
                    <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="Dutch" class="language"> Dutch</label>
                    <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="Chinese" class="language"> Chinese</label>
                </div>
                
                <button class="add-to-cart-btn" disabled>Add to Cart</button>
            </div>
        <?php endforeach; ?>

    </div>

</div>

    <script src="/js/History/HistoryAddingToCart.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>
