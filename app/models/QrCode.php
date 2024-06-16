<?php

namespace App\Models;

class QrCode
{
    private $user_ticket_Id;
    private $scan;

    public function __construct($user_ticket_Id, $scan)
    {
        $this->user_ticket_Id = $user_ticket_Id;
        $this->scan = $scan;
    }

    public function getUserTicketId()
    {
        return $this->user_ticket_Id;
    }

    public function getScan()
    {
        return $this->scan;
    }

}