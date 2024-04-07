<?php

namespace App\Controllers;

use App\Services\UserTicketService;

class FestPlanController
{
    private UserTicketService $userTicketService;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
    }

    public function index(): void
    {
        // TODO: Get the actual user id
        $tickets = $this->userTicketService->getAllTicketsByUserId(1);
        include '../views/festplan.php';
    }
}