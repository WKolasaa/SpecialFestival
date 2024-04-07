<?php
include __DIR__ . '/../header.php';
?>

<div class="content">
  <h2>Order Management</h2>
  <div class="exportOrders">
    <div class="exportBy">
      <select class="form-select combo-box" id="exportType" aria-label="Floating label select example">
        <option value="csv">CSV</option>
        <option value="xlsx">Excel</option>
      </select>
      <button type="button" class="btn btn-export" id="exportBtn">Export</button>
    </div>
  </div>
  </div>

  <table class="table" id="orderTable">
    <thead id="tableHead" class="bg-primary text-white">
      <tr>
        <th class="id-column">ID</th>
        <th class="eventName-column">Event Name</th>
        <th class="ticketType-column">Ticket Type</th>
        <th class="ticketName-column">Ticket Name</th>
        <th class="location-column">Location</th>
        <th class="price-column">Price</th>
        <th class="startDate-column">Start Date</th>
        <th class="endDate-column">End Date</th>
      </tr>
    </thead>
    <tbody id="orderList">
      <?php if ($orders !== null): ?>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= $order->getTicketId() ?></td>
            <td><?= $order->getEventName() ?></td>
            <td><?= $order->getTicketTypeAsString() ?></td>
            <td><?= $order->getTicketName() ?></td>
            <td><?= $order->getLocation() ?></td>
            <td><?= $order->getPrice() ?></td>
            <td><?= $order->getStartDate()->format('Y-m-d H:i:s') ?></td>
            <td><?= $order->getEndDate()->format('Y-m-d H:i:s') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="8">No orders found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="/js/adminViews/Orders.js"></script>

<?php
include __DIR__ . '/../footer.php';
?>