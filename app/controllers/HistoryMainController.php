<?php

namespace App\Controllers;

use App\Services\HistoryAdminService;

class HistoryMainController
{
    private $service;

    public function __construct()
    {

        $this->service = new HistoryAdminService();

    }

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
        include '../views/HistoryView/HistoryAddingToCart.php';

    }
}