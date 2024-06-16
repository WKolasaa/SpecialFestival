<?php

namespace App\Models;

use JsonSerializable;

class DanceOverview implements JsonSerializable
{
    private $id;
    private $header;
    private $subHeader;
    private $text;// both description and artist description are text
    private $imageName;


    public function __construct($id, $header, $subHeader, $text, $imageName)
    {
        $this->id = $id;
        $this->header = $header;
        $this->subHeader = $subHeader;
        $this->text = $text;
        $this->imageName = $imageName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function getSubHeader()
    {
        return $this->subHeader;
    }

    public function setSubHeader($subHeader)
    {
        $this->subHeader = $subHeader;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function jsonSerialize(): mixed
    {
        // return [
        //   'id' => $this->id,
        //   'text' => $this->text,
        //   'imageName' => $this->imageName
        // ];

        $vars = get_object_vars($this);
        return $vars;
    }

}