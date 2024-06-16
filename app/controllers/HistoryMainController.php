<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;

class HistoryMainController
{
    private $service;


    public function index()
    {
        $service = $this->getHistoryAdminService();
        include '../views/HistoryView/HistoryMain.php';

    }

    private function getHistoryAdminService()
    {
        return new HistoryAdminService();
    }

    public function port()
    {
        $service = $this->getHistoryAdminService();
        include '../views/HistoryView/HistoryPort.php';

    }

    public function windmill()
    {
        $service = $this->getHistoryAdminService();
        include '../views/HistoryView/HistoryWindmill.php';

    }

    public function cart()
    {
        $service = $this->getHistoryAdminService();
        include '../views/HistoryView/HistoryAddingToCart.php';

    }

    public function timeslots()
    {
        $service = $this->getHistoryAdminService();
        include '../views/HistoryView/EditTimeslots.php';

    }
}