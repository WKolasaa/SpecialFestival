<?php

namespace App\Models;

class RestaurantSession
{
    private $id;
    private $restaurantId;
    private $event_date;
    private $event_day;
    private $event_time_start;
    private $event_time_end;
    private $seats_total;
    private $seats_left;

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

    public function getEventDate()
    {
        return $this->event_date;
    }

    public function setEventDate($event_date)
    {
        $this->event_date = $event_date;
    }

    public function getEventDay()
    {
        return $this->event_day;
    }

    public function setEventDay($event_day)
    {
        $this->event_day = $event_day;
    }

    public function getEventTimeStart()
    {
        return $this->event_time_start;
    }

    public function setEventTimeStart($event_time_start)
    {
        $this->event_time_start = $event_time_start;
    }

    public function getEventTimeEnd()
    {
        return $this->event_time_end;
    }

    public function setEventTimeEnd($event_time_end)
    {
        $this->event_time_end = $event_time_end;
    }

    public function getSeatsTotal()
    {
        return $this->seats_total;
    }

    public function setSeatsTotal($seats_total)
    {
        $this->seats_total = $seats_total;
    }

    public function getSeatsLeft()
    {
        return $this->seats_left;
    }

    public function setSeatsLeft($seats_left)
    {
        $this->seats_left = $seats_left;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantId,
            'event_date' => $this->event_date,
            'event_day' => $this->event_day,
            'event_time_start' => $this->event_time_start,
            'event_time_end' => $this->event_time_end,
            'seats_total' => $this->seats_total,
            'seats_left' => $this->seats_left
        ];
    }
}