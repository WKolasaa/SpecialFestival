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

    public function getAllUserTicketsByUserId(int $userId, bool $paid): array
    {
        $userTicketData = $this->userTicketRepository->getAllUserTicketsByUserId($userId, $paid);
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
        // TODO: Get the actual user
//        if ($user->paymentInProgress) {
//            throw new Exception("Cannot add tickets while payment is in progress");
//        }

        if ($this->userTicketRepository->hasTicket($ticket, $userId)) {
            $this->increaseTicketQuantity($ticket->getId(), $userId);
        } else {
            $this->userTicketRepository->addUserTicket($ticket, $userId);
        }
    }

    public function increaseTicketQuantity(int $ticketId, int $userId): void
    {
        $this->userTicketRepository->addTicketQuantity($ticketId, $userId, 1);
    }

    public function decreaseTicketQuantity(int $ticketId, int $userId): void
    {
        $this->userTicketRepository->addTicketQuantity($ticketId, $userId, -1);
    }

    public function markTicketsAsPaid(int $userId): void
    {
        $this->userTicketRepository->markTicketsAsPaid($userId);
    }

    public function deleteTicket(int $ticketId, int $userId): void
    {
        $this->userTicketRepository->deleteQrCode($ticketId);
        $this->userTicketRepository->deleteTicket($ticketId, $userId);
    }

    public function generateShareToken(int $userId): string {
        $token = $this->userTicketRepository->getShareTokenByUserId($userId);

        if ($token == null) {
            return $this->userTicketRepository->generateShareToken($userId);
        } else {
            return $token;
        }
    }

    public function getUserIdByShareToken(string $token): int {
        return $this->userTicketRepository->getUserIdByShareToken($token);
    }

    public function updateTicketAvailability(int $userId, int $amount) {
        $ticketIds = $this->userTicketRepository->getTicketIdsByUserId($userId);

        $this->ticketRepository->updateTicketAvailability($ticketIds, $amount);
    }
}