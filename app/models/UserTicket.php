<?php

namespace App\Models;

class UserTicket
{
    public Ticket $ticket;
    public int $quantity;
    public bool $paid;
}