<?php include __DIR__ . '/../header.php'; ?>

<div class="tour-promotion">
    <div class="promotion-text">
        <h1>Secure Your Haarlem Tour Now!</h1>
        <p>You're just a click away from exploring the picturesque streets of Haarlem! Secure your spot now and dive into the rich history and vibrant culture of this enchanting city. Book your ticket today and embark on an unforgettable journey through this historic city.</p>
    </div>
    <div class="promotion-image">
        <img src="/img/History/PaymentPagePicture.png" alt="Haarlem Tour">
    </div>
</div>

<div class="ticket-selection-container">
    <div class="timeslots-section">
        <h2 class="timeslots-title">Timeslots</h2>
        <?php
        $timeslots = $service->getAllTimeslots(); // Fetch timeslots from the service
        $regularPrice = $service->getContent("History Main", "Regular Ticket Price");
        $familyPrice = $service->getContent("History Main", "Family Ticket Price");
        foreach ($timeslots as $timeslot):
            // Convert the 'day' from Y-m-d to a more readable format
            $formattedDate = date("F j, Y", strtotime($timeslot->getDay()));
        ?>
            <div class="timeslot" data-timeslot-id="<?= htmlspecialchars($timeslot->getId()) ?>">
                <h3>Date: <span class="day"><?= htmlspecialchars($formattedDate) ?></span></h3>
                <p><strong>Time:</strong> <span class="start-time"><?= htmlspecialchars($timeslot->getStartTime()) ?></span> - <span class="end-time"><?= htmlspecialchars($timeslot->getEndTime()) ?></span></p>
                <div>
                    <strong>Ticket Type:</strong>
                    <label><input type="radio" name="price_<?= htmlspecialchars($timeslot->getId()) ?>" value="<?= htmlspecialchars($regularPrice) ?>" data-ticket-type="Regular" class="ticket-type"> Regular Ticket - $<?= htmlspecialchars($regularPrice) ?></label>
                    <label><input type="radio" name="price_<?= htmlspecialchars($timeslot->getId()) ?>" value="<?= htmlspecialchars($familyPrice) ?>" data-ticket-type="Family" class="ticket-type"> Family Ticket - $<?= htmlspecialchars($familyPrice) ?></label>
                </div>
                <div>
                    <strong>Language:</strong>
                        <?php if ((int)$timeslot->getEnglishTour() > 0): ?>
                            <label><input type="radio" name="language_<?= htmlspecialchars($timeslot->getId()) ?>" value="English" class="language"> English</label>
                        <?php endif; ?>
                        <?php if ((int)$timeslot->getDutchTour() > 0): ?>
                            <label><input type="radio" name="language_<?= htmlspecialchars($timeslot->getId()) ?>" value="Dutch" class="language"> Dutch</label>
                        <?php endif; ?>
                        <?php if ((int)$timeslot->getChineseTour() > 0): ?>
                            <label><input type="radio" name="language_<?= htmlspecialchars($timeslot->getId()) ?>" value="Chinese" class="language"> Chinese</label>
                        <?php endif; ?>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="/js/History/HistoryAddingToCart.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>
