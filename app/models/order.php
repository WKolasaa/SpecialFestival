<?php

namespace App\Models;

use DateTime;

class Order
{
    private $id;
    private $ticketName;
    private $eventName;
    private bool $paid;
    private $totalPrice;
    private DateTime $orderedAt;

    public function __construct($id, $ticketName, $eventName, $paid, $totalPrice, $ordered_at)
    {
        $this->id = $id;
        $this->ticketName = $ticketName;
        $this->eventName = $eventName;
        $this->paid = $paid;
        $this->totalPrice = $totalPrice;
        $this->orderedAt = $ordered_at;
    }

    public function getOrderId()
    {
        return $this->id;
    }

    public function getTicketName()
    {
        return $this->ticketName;
    }

    public function setTicketName($ticketName)
    {
        $this->ticketName = $ticketName;
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    public function isPaid()
    {
        return $this->paid;
    }

    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function getOrderedAt()
    {
        return $this->orderedAt;
    }

    public function setOrderedAt($orderedAt)
    {
        $this->orderedAt = $orderedAt;
    }

    public function setOrderId($id)
    {
        $this->id = $id;
    }


}