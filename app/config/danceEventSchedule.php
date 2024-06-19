<?php
// Generate event dates dynamically
$startDate = strtotime('2024-07-26');
$endDate = strtotime('2024-07-28');

while ($startDate <= $endDate) {
    $dateString = date('Y-m-d', $startDate);
    $displayDate = date('d-m-Y', $startDate);
    echo "<option value='$dateString'>$displayDate</option>";
    $startDate = strtotime('+1 day', $startDate);
}
