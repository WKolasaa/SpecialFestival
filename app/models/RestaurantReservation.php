<?php

namespace App\Models;

class RestaurantReservation
{
    private $id; //
    private $restaurantId; //
    private $eventID;
    private $regularTickets; //
    private $reducedTickets; //
    private $specialRequests; //
    private $enabled;
    private $date; //
    private $startTime; //
    private $endTime; //

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRestaurantId()
    {
        return $this->restaurantId;
    }

    public function setRestaurantId($restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }

    public function getEventID()
    {
        return $this->eventID;
    }

    public function setEventID($eventID)
    {
        $this->eventID = $eventID;
    }

    public function getRegularTickets()
    {
        return $this->regularTickets;
    }

    public function setRegularTickets($regularTickets)
    {
        $this->regularTickets = $regularTickets;
    }

    public function getReducedTickets()
    {
        return $this->reducedTickets;
    }

    public function setReducedTickets($reducedTickets)
    {
        $this->reducedTickets = $reducedTickets;
    }

    public function getSpecialRequests()
    {
        return $this->specialRequests;
    }

    public function setSpecialRequests($specialRequests)
    {
        $this->specialRequests = $specialRequests;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function toArray()
    {
        return array(
            "id" => $this->id,
            "restaurantId" => $this->restaurantId,
            "eventID" => $this->eventID,
            "regularTickets" => $this->regularTickets,
            "reducedTickets" => $this->reducedTickets,
            "specialRequests" => $this->specialRequests,
            "enabled" => $this->enabled,
            "date" => $this->date,
            "startTime" => $this->startTime,
            "endTime" => $this->endTime
        );
    }

}