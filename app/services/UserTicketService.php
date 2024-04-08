<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\UserTicket;
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

    public function getAllUserTicketsByUserId(int $userId): array
    {
        $userTicketData = $this->userTicketRepository->getAllUserTicketsByUserId($userId);
        $userTickets = [];
        foreach ($userTicketData as $data) {
            $userTicket = new UserTicket();
            $userTicket->ticket = $this->ticketRepository->getTicketById($data['ticket_id']);
            $userTicket->quantity = $data['quantity'];
            $userTicket->paid = $data['paid'];
            $userTickets[] = $userTicket;
        }
        return $userTickets;
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