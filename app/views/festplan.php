<?php include __DIR__ . '/header.php'; ?>

    <div class="festplan">
        <div>
            <div class="program-title">Program Overview</div>
            <div class="my-program">
                <div>
                    <img src="/img/FestPlan/Ticket.png" alt="Ticket Icon">
                    <span>MY PROGRAM</span>
                </div>
                <button class="btn btn-light share-btn"><i class="far fa-regular fa-paper-plane"></i> SHARE</button>
            </div>
        </div>

        <table class="table table-sm table-dark">
            <thead>
            <tr>
                <th>Events</th>
                <th>Info</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody id="eventData">
            <?php foreach ($userTickets as $userTicket): ?>
                <tr data-ticket-id="<?= $userTicket->ticket->getId() ?>">
                    <td><?= $userTicket->ticket->getEventName() ?></td>
                    <td><?= $userTicket->ticket->getTicketName() ?></td>
                    <td><?= $userTicket->ticket->getPrice() ?></td>
                    <td>
                        <button class="quantity-decrease">-</button>
                        <span class="quantity"><?= $userTicket->quantity ?></span>
                        <button class="quantity-increase">+</button>
                        <button class="delete-ticket">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="/FestPlan/checkout" method="post">
            <button id="checkoutButton" class="btn btn-primary" type="submit">Check out</button>
        </form>
    </div>

<script src="js/festplan.js">const userId = <?= json_encode($_SESSION['userId']) ?>;</script>

<?php include __DIR__ . '/footer.php'; ?>