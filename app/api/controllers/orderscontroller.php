<?php
namespace App\Controllers;

use App\Services\OrderService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OrdersController
{
  private $orderService;

  function __construct()
  {
    $this->orderService = new OrderService();
  }
  public function exportOrders()
  {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Retrieve the active worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    $orders = $this->orderService->getAllTickets(); // change it later

    // TODO: Fetch your orders data from the database and populate the worksheet
    // For now, let's just add some static data
    $worksheet->setCellValue('A1', 'Order ID');
    $worksheet->setCellValue('B1', 'Event Name');
    $worksheet->setCellValue('C1', 'Ticket Type');
    $worksheet->setCellValue('D1', 'Ticket Name');
    $worksheet->setCellValue('E1', 'Location');
    $worksheet->setCellValue('F1', 'Price');
    $worksheet->setCellValue('G1', 'Start Date');
    $worksheet->setCellValue('H1', 'End Date');
    $row = 2; // Start from the second row because the first row is for the header
    foreach ($orders as $order) {
      $worksheet->setCellValue('A' . $row, $order->getTicketId());
      $worksheet->setCellValue('B' . $row, $order->getEventName());
      $worksheet->setCellValue('C' . $row, $order->getTicketTypeAsString());
      $worksheet->setCellValue('D' . $row, $order->getTicketName());
      $worksheet->setCellValue('E' . $row, $order->getLocation());
      $worksheet->setCellValue('F' . $row, $order->getPrice());
      $worksheet->setCellValue('G' . $row, $order->getStartDate());
      $worksheet->setCellValue('H' . $row, $order->getEndDate());
      $row++;
    }
    // Create a new Xlsx writer
    $writer = new Xlsx($spreadsheet);

    // Create a temporary file in the system
    $temp_file = tempnam(sys_get_temp_dir(), 'phpspreadsheet');

    // Write the spreadsheet to the temporary file
    $writer->save($temp_file);

    // Return the excel file to the browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="orders.xlsx"');
    header('Cache-Control: max-age=0');

    // Read the file
    readfile($temp_file);

    // Delete the temporary file
    unlink($temp_file);
  }


}