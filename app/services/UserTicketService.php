<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use App\Repositories\UserTicketRepository;

class UserTicketService
{
    private UserTicketRepository $userTicketRepository;
    private TicketRepository $ticketRepository;

    function __construct()
    {
        $this->userTicketRepository = new UserTicketRepository();
        $this->ticketRepository = new TicketRepository();
    }

    public function getAllTicketsByUserId(int $userId): array
    {
        $ticketIds = $this->userTicketRepository->getAllTicketIdsByUserId($userId);
        $tickets = [];
        foreach ($ticketIds as $ticketId) {
            $ticket = $this->ticketRepository->getTicketById($ticketId);
            $tickets[] = $ticket;
        }
        return $tickets;
    }

    public function addUserTicket(Ticket $ticket, int $userId): void
    {
        if ($this->userTicketRepository->hasTicket($ticket, $userId)) {
            $this->increaseTicketQuantity($ticket, $userId);
        } else {
            $this->userTicketRepository->addUserTicket($ticket, $userId);
        }
    }

    public function increaseTicketQuantity(Ticket $ticket, int $userId): void
    {
        $this->userTicketRepository->addTicketQuantity($ticket, $userId, 1);
    }

    public function decreaseTicketQuantity(Ticket $ticket, int $userId): void
    {
        $this->userTicketRepository->addTicketQuantity($ticket, $userId, -1);
    }
}