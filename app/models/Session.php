<?php

namespace App\Models;

use JsonSerializable;

class Session implements JsonSerializable
{

    private $sessionId;
    private $artistName;
    private $startSession;
    private $endSession;
    private $sessionDate;
    private $venue;
    private $sessionPrice;
    private $sessionType;

    public function __construct($sessionId, $artistName, $startSession, $sessionDate, $venue, $sessionPrice, $sessionType, $endSession)
    {
        $this->sessionId = $sessionId;
        $this->artistName = $artistName;
        $this->startSession = $startSession;
        $this->sessionDate = $sessionDate;
        $this->venue = $venue;
        $this->sessionPrice = $sessionPrice;
        $this->sessionType = $sessionType;
        $this->endSession = $endSession;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getArtistName()
    {
        return $this->artistName;
    }

    public function setArtistName($artistName)
    {
        $this->artistName = $artistName;
    }

    public function getStartSession()
    {
        return $this->startSession;
    }

    public function setStartSession($startSession)
    {
        $this->startSession = $startSession;
    }

    public function getSessionDate()
    {
        return $this->sessionDate;
    }

    public function setSessionDate($sessionDate)
    {
        $this->sessionDate = $sessionDate;
    }

    public function getVenue()
    {
        return $this->venue;
    }

    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    public function getSessionPrice()
    {
        return $this->sessionPrice;
    }

    public function setSessionPrice($sessionPrice)
    {
        $this->sessionPrice = $sessionPrice;
    }

    public function getSessionType()
    {
        return $this->sessionType;
    }

    public function setSessionType($sessionType)
    {
        $this->sessionType = $sessionType;
    }

    public function getEndSession()
    {
        return $this->endSession;
    }

    public function setEndSession($endSession)
    {
        $this->endSession = $endSession;
    }

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        return $vars;
    }

}