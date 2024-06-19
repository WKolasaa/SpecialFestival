<?php

namespace App\Models;

use JsonSerializable;

class Restaurant implements JsonSerializable
{
    private $id;
    private $name;
    private $address;
    private $type;
    private $price;
    private $reduced;
    private $stars;
    private $phoneNumber;
    private $email;
    private $website;
    private $chef;
    private $images = [];
    private $events = [];

    public function __construct()
    {

    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getReduced()
    {
        return $this->reduced;
    }

    public function setReduced($reduced)
    {
        $this->reduced = $reduced;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function getChef()
    {
        return $this->chef;
    }

    public function setChef($chef)
    {
        $this->chef = $chef;
    }

    public function addImage($restaurantImage)
    {
        $this->images[] = $restaurantImage;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getImagesAsArray()
    {
        $images = [];
        foreach ($this->images as $image) {
            array_push($images, $image->toArray());
        }
        return $images;
    }

    public function getImagesByType($type)
    {
        $images = [];
        foreach ($this->images as $image) {
            if ($image->getImageType() == $type) {
                array_push($images, $image);
            }
        }
        return $images;
    }

    public function addEvent($restaurantSession)
    {
        $this->events[] = $restaurantSession;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function getEventsAsArray()
    {
        $events = [];
        foreach ($this->events as $event) {
            array_push($events, $event->toArray());
        }
        return $events;
    }

    public function getEventByRestaurantId($id)
    {
        $events = [];
        foreach ($this->events as $event) {
            if ($event->getRestaurantId() == $id) {
                array_push($events, $event);
            }
        }
        return $events;
    }

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        return $vars;
    }

}