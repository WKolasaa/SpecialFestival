<?php

namespace App\Models;

class RestaurantImage
{
    private $id;
    private $restaurantId;
    private $imagePath;
    private $imageType;

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

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getImageType()
    {
        return $this->imageType;
    }

    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'restaurantId' => $this->restaurantId,
            'imagePath' => $this->imagePath,
            'imageType' => $this->imageType
        ];
    }
}