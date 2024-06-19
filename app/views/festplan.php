<?php use App\Models\TicketType;

include __DIR__ . '/header.php';
$tokenIsSet = isset($_GET['token']);
?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            // Create an array of events from user tickets
            var events = [];
            <?php foreach ($userTickets as $userTicket): ?>
            events.push({
                title: '<?= $userTicket->ticket->getTicketName() ?>',
                start: '<?= $userTicket->ticket->getStartDate()->format('Y-m-d H:i:s') ?>',
                end: '<?= $userTicket->ticket->getEndDate()->format('Y-m-d H:i:s') ?>',
                // Add additional data here
                eventName: '<?= $userTicket->ticket->getEventName() ?>',
                location: '<?= $userTicket->ticket->getLocation() ?>',
            });
            <?php endforeach; ?>

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                events: events,
                eventContent: function (arg) {
                    var html = '<div class="event">';
                    html += '<div class="event-ticket-name">' + arg.event.extendedProps.eventName + '</div>';
                    html += '<div class="event-location">' + arg.event.extendedProps.location + '</div>';
                    html += '</div>';

                    return {html: html};
                }
            });
            calendar.render();
        });
    </script>

    <div class="festplan">
        <div>
            <div class="program-title">Program Overview</div>
            <div class="my-program">
                <div>
                    <img src="/img/FestPlan/Ticket.png" alt="Ticket Icon">
                    <span>MY PROGRAM</span>
                </div>
                <?php if (!$tokenIsSet): ?>
                    <button class="btn btn-light share-btn"><i class="far fa-regular fa-paper-plane"></i> SHARE</button>
                <?php endif; ?>
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
                <tr data-ticket-id="<?= $userTicket->ticket->getTicketId() ?>">
                    <td><?= $userTicket->ticket->getEventName() ?></td>
                    <td><?= $userTicket->ticket->getTicketName() ?></td>
                    <td><?= $userTicket->ticket->getPrice() ?></td>
                    <td>
                        <?php if (!$tokenIsSet && $userTicket->ticket->getTicketType() != TicketType::Yummy): ?>
                            <button class="btn btn-primary quantity-controls quantity-increase">+</button>
                        <?php endif; ?>
                        <span class="quantity"><?= $userTicket->quantity ?></span>
                        <?php if (!$tokenIsSet && $userTicket->ticket->getTicketType() != TicketType::Yummy): ?>
                            <button class="btn btn-primary quantity-controls quantity-decrease">-</button>
                        <?php endif; ?>
                        <?php if (!$tokenIsSet): ?>
                            <button class="btn btn-danger delete-ticket">Delete</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!$tokenIsSet): ?>
            <form action="/FestPlan/checkout" method="post">
                <button id="checkoutButton" class="btn btn-primary" type="submit">Check out</button>
            </form>
        <?php endif; ?>

        <div id='calendar'></div>
    </div>

<?php if (!$tokenIsSet): ?>
    <script>
        const userId = <?= $userId ?>;
    </script>
    <script src="js/festplan.js"></script>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>