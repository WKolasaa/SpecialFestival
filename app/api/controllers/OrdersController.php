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
        $orders = $this->orderService->getAllOrders();
        // var_dump($orders);

        // For now, let's just add some static data
        $worksheet->setCellValue('A1', 'Order ID');
        $worksheet->setCellValue('B1', 'Ticket Name');
        $worksheet->setCellValue('C1', 'Event Name');
        $worksheet->setCellValue('D1', 'Payment Status');
        $worksheet->setCellValue('E1', 'Total Amount');
        $worksheet->setCellValue('F1', 'Order Date');
        $row = 2; // Start from the second row because the first row is for the header
        foreach ($orders as $order) {
            $worksheet->setCellValue('A' . $row, $order->getOrderId());
            $worksheet->setCellValue('B' . $row, $order->getTicketName());
            $worksheet->setCellValue('C' . $row, $order->getEventName());
            $worksheet->setCellValue('D' . $row, $order->isPaid());
            $worksheet->setCellValue('E' . $row, $order->getTotalPrice());
            $worksheet->setCellValue('F' . $row, $order->getOrderedAt());
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