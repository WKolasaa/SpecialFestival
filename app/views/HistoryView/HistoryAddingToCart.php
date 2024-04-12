<?php include __DIR__ . '/../header.php'; ?>


<div class="ticket-selection-container">
    <div class="timeslots-section">
        <h2 class="timeslots-title">Timeslots</h2>
        <?php
        $timeslots = $service->getAllTimeslots(); // Fetch timeslots from the service
        $regularPrice = $service->getContent("History Main", "Regular Ticket Price");
        $familyPrice = $service->getContent("History Main", "Family Ticket Price");
        foreach ($timeslots as $timeslot):
            // Convert the 'day' from Y-m-d to a more readable format
            $formattedDate = date("F j, Y", strtotime($timeslot['day']));
        ?>
            <div class="timeslot" data-timeslot-id="<?= $timeslot['id'] ?>">
                <h3>Date: <span class="day"><?= htmlspecialchars($timeslot['day']) ?></span></h3>
                <p><strong>Time:</strong> <span class="start-time"><?= htmlspecialchars($timeslot['start_time']) ?></span> - <span class="end-time"><?= htmlspecialchars($timeslot['end_time']) ?></span></p>
                <div>
                    <strong>Ticket Type:</strong>
                    <label><input type="radio" name="price_<?= $timeslot['id'] ?>" value="<?= htmlspecialchars($regularPrice) ?>" data-ticket-type="Regular" class="ticket-type"> Regular Ticket - $<?= htmlspecialchars($regularPrice) ?></label>
                    <label><input type="radio" name="price_<?= $timeslot['id'] ?>" value="<?= htmlspecialchars($familyPrice) ?>" data-ticket-type="Family" class="ticket-type"> Family Ticket - $<?= htmlspecialchars($familyPrice) ?></label>
                </div>
                <div>
                    <strong>Language:</strong>
                        <?php if ((int)$timeslot['english_tour'] > 0): ?>
                            <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="English" class="language"> English</label>
                        <?php endif; ?>
                        <?php if ((int)$timeslot['dutch_tour'] > 0): ?>
                            <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="Dutch" class="language"> Dutch</label>
                        <?php endif; ?>
                        <?php if ((int)$timeslot['chinese_tour'] > 0): ?>
                            <label><input type="radio" name="language_<?= $timeslot['id'] ?>" value="Chinese" class="language"> Chinese</label>
                        <?php endif; ?>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>


</div>
    <script src="/js/History/HistoryAddingToCart.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>
