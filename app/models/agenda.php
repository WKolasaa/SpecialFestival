<?php
namespace App\Models;

class Agenda implements \JsonSerializable{
  private $agendaId;
  private $artistName;
  private $eventDay;
  private $eventDate;
  private $eventTime;
  private$durationMinutes;
  private $ticketPrice;
  private $ticketsAvailable;
  private $venueAddress;

  public function __construct($agendaId, $artistName, $eventDay, $eventDate, $eventTime, $durationMinutes, $ticketPrice, $ticketsAvailable, $venueAddress) {
      $this->agendaId = $agendaId;
      $this->artistName = $artistName;
      $this->eventDay = $eventDay;
      $this->eventDate = $eventDate;
      $this->eventTime = $eventTime;
      $this->durationMinutes = $durationMinutes;
      $this->ticketPrice = $ticketPrice;
      $this->ticketsAvailable = $ticketsAvailable;
      $this->venueAddress = $venueAddress;
  }

  public function getAgendaId(){
    return $this->agendaId;
  }
  public function getArtistName(){
    return $this->artistName;
  }

  public function getEventDay(){
    return $this->eventDay;
  }
  public function getEventDate(){
    return $this->eventDate;
  }
  public function getEventTime(){
    return $this->eventTime;
  }
  public function getDurationMinutes(){
    return $this->durationMinutes;
  }
  public function getTicketPrice(){
    return $this->ticketPrice;
  }
  public function getTicketsAvailable(){
    return $this->ticketsAvailable;
  }
  public function getVenueAddress(){
    return $this->venueAddress;
  }
  public function setAgendaId($agendaId){
    $this->agendaId = $agendaId;
  }

  public function setArtistName($artistName){
    $this->artistName = $artistName;
  }
  public function setEventDay($eventDay){
    $this->eventDay = $eventDay;
  }
  public function setEventDate($eventDate){
    $this->eventDate = $eventDate;
  }
  public function setEventTime($eventTime){
    $this->eventTime = $eventTime;
  }
  public function setDurationMinutes($durationMinutes){
    $this->durationMinutes = $durationMinutes;
  }

  public function setTicketPrice($ticketPrice){
    $this->ticketPrice = $ticketPrice;
  }
  public function setTicketsAvailable($ticketsAvailable){
    $this->ticketsAvailable = $ticketsAvailable;
  }
  public function setVenueAddress($venueAddress){
    $this->venueAddress = $venueAddress;
  }

  public function jsonSerialize():mixed
  {
    $vars=get_object_vars($this);
    return $vars;

  }

}