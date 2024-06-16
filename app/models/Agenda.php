<?php

namespace App\Models;

use JsonSerializable;

class Agenda implements JsonSerializable
{
    private $agendaId;
    private $artistName;
    private $eventDay;
    private $eventDate;
    private $eventTime;
    private $durationMinutes;
    private $sessionPrice;
    private $sessionsAvailable;
    private $venueAddress;

    public function __construct($agendaId, $artistName, $eventDay, $eventDate, $eventTime, $durationMinutes, $sessionPrice, $sessionsAvailable, $venueAddress)
    {
        $this->agendaId = $agendaId;
        $this->artistName = $artistName;
        $this->eventDay = $eventDay;
        $this->eventDate = $eventDate;
        $this->eventTime = $eventTime;
        $this->durationMinutes = $durationMinutes;
        $this->sessionPrice = $sessionPrice;
        $this->sessionsAvailable = $sessionsAvailable;
        $this->venueAddress = $venueAddress;
    }

    public function getAgendaId()
    {
        return $this->agendaId;
    }

    public function setAgendaId($agendaId)
    {
        $this->agendaId = $agendaId;
    }

    public function getArtistName()
    {
        return $this->artistName;
    }

    public function setArtistName($artistName)
    {
        $this->artistName = $artistName;
    }

    public function getEventDay()
    {
        return $this->eventDay;
    }

    public function setEventDay($eventDay)
    {
        $this->eventDay = $eventDay;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function getEventTime()
    {
        return $this->eventTime;
    }

    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;
    }

    public function getDurationMinutes()
    {
        return $this->durationMinutes;
    }

    public function setDurationMinutes($durationMinutes)
    {
        $this->durationMinutes = $durationMinutes;
    }

    public function getSessionPrice()
    {
        return $this->sessionPrice;
    }

    public function setSessionPrice($sessionPrice)
    {
        $this->sessionPrice = $sessionPrice;
    }

    public function getSessionsAvailable()
    {
        return $this->sessionsAvailable;
    }

    public function setSessionsAvailable($sessionsAvailable)
    {
        $this->sessionsAvailable = $sessionsAvailable;
    }

    public function getVenueAddress()
    {
        return $this->venueAddress;
    }

    public function setVenueAddress($venueAddress)
    {
        $this->venueAddress = $venueAddress;
    }

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        return $vars;

    }

}