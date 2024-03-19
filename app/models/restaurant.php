<?php
namespace App\Models;
class Restaurant {
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
    private $images = [
        'map' => '',
        'chef' => '',
        'gallery' => []
    ];
    private $events = [
        'event_date' => [
            'event_day' => 'day_of_week',
            'sessions' => [
                [
                    'event_time_start' => 'start_time',
                    'event_time_end' => 'end_time',
                    'seats_total' => 'total_seats',
                    'seats_left' => 'seats_available'
                ],
            ]
        ],
    ];

    public function __construct() {

    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getReduced() {
        return $this->reduced;
    }

    public function setReduced($reduced) {
        $this->reduced = $reduced;
    }

    public function getStars() {
        return $this->stars;
    }

    public function setStars($stars) {
        $this->stars = $stars;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getChef() {
        return $this->chef;
    }

    public function setChef($chef) {
        $this->chef = $chef;
    }

    public function setImagePath($type, $path) {
        if ($type === 'gallery') {
            $this->images[$type][] = $path;
        } else {
            $this->images[$type] = $path;
        }
    }

    public function getImages($type = null) {
        if ($type === null) {
            return $this->images;
        } else {
            return $this->images[$type] ?? null;
        }
    }

    public function setEvent($event) {
        $this->events[] = $event;
    }

    public function getEvents() {
        return $this->events;
    }
}