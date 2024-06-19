<?php

namespace App\Models;

use JsonSerializable;

class Artist implements JsonSerializable
{
    private $artistId;
    private $artistName;
    private $style;
    private $description;
    private $title;
    private $participationDate;
    private $imageName;

    public function __construct($artistId, $artistName, $style, $description, $title, $participationDate, $imageName)
    {
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->style = $style;
        $this->description = $description;
        $this->title = $title;
        $this->participationDate = $participationDate;
        $this->imageName = $imageName;

    }

    public function getArtistId()
    {
        return $this->artistId;
    }

    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;
    }

    public function getArtistName()
    {
        return $this->artistName;
    }

    public function setArtistName($artistName)
    {
        $this->artistName = $artistName;
    }

    public function getStyle()
    {
        return $this->style;
    }

    public function setStyle($style)
    {
        $this->style = $style;
    }

    public function getParticipationDate()
    {
        return $this->participationDate;
    }

    public function setParticipationDate($participationDate)
    {
        $this->participationDate = $participationDate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getImageName()
    {// New line
        return $this->imageName;// New line
    }

    public function setImageName($imageName)
    {// New line
        $this->imageName = $imageName;// New line
    }

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        return $vars;

    }
}