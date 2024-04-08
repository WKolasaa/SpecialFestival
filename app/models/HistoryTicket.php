<?php
namespace App\Models;

class EventTicket implements \JsonSerializable {

    private $id;
    private $eventDate;
    private $startTime;
    private $endTime;
    private $language;
    private $regularTicketPrice;
    private $regularTicketDrinks;
    private $familyTicketPrice;
    private $familyTicketDrinks;
    private $maxFamilyTicketMembers;

    public function __construct($id, $eventDate, $startTime, $endTime, $language, $regularTicketPrice, $regularTicketDrinks, $familyTicketPrice, $familyTicketDrinks, $maxFamilyTicketMembers) {
        $this->id = $id;
        $this->eventDate = $eventDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->language = $language;
        $this->regularTicketPrice = $regularTicketPrice;
        $this->regularTicketDrinks = $regularTicketDrinks;
        $this->familyTicketPrice = $familyTicketPrice;
        $this->familyTicketDrinks = $familyTicketDrinks;
        $this->maxFamilyTicketMembers = $maxFamilyTicketMembers;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getEventDate() { return $this->eventDate; }
    public function getStartTime() { return $this->startTime; }
    public function getEndTime() { return $this->endTime; }
    public function getLanguage() { return $this->language; }
    public function getRegularTicketPrice() { return $this->regularTicketPrice; }
    public function getRegularTicketDrinks() { return $this->regularTicketDrinks; }
    public function getFamilyTicketPrice() { return $this->familyTicketPrice; }
    public function getFamilyTicketDrinks() { return $this->familyTicketDrinks; }
    public function getMaxFamilyTicketMembers() { return $this->maxFamilyTicketMembers; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setEventDate($eventDate) { $this->eventDate = $eventDate; }
    public function setStartTime($startTime) { $this->startTime = $startTime; }
    public function setEndTime($endTime) { $this->endTime = $endTime; }
    public function setLanguage($language) { $this->language = $language; }
    public function setRegularTicketPrice($regularTicketPrice) { $this->regularTicketPrice = $regularTicketPrice; }
    public function setRegularTicketDrinks($regularTicketDrinks) { $this->regularTicketDrinks = $regularTicketDrinks; }
    public function setFamilyTicketPrice($familyTicketPrice) { $this->familyTicketPrice = $familyTicketPrice; }
    public function setFamilyTicketDrinks($familyTicketDrinks) { $this->familyTicketDrinks = $familyTicketDrinks; }
    public function setMaxFamilyTicketMembers($maxFamilyTicketMembers) { $this->maxFamilyTicketMembers = $maxFamilyTicketMembers; }

    // Implement jsonSerialize
    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }
}
