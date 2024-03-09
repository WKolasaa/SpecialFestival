<?php
namespace App\Models;

class Ticket implements \JsonSerializable{

  private $ticketId;
  private $artistName;
  private $sessionTime;
  private $sessionDate;
  private $venue;
  private $ticketPrice;

  public function __construct($ticketId, $artistName, $sessionTime, $sessionDate, $venue, $ticketPrice) {
      $this->ticketId = $ticketId;
      $this->artistName = $artistName;
      $this->sessionTime = $sessionTime;
      $this->sessionDate = $sessionDate;
      $this->venue = $venue;
      $this->ticketPrice = $ticketPrice;
  }

  public function getTicketId(){
    return $this->ticketId;
  }
  public function getArtistName(){
    return $this->artistName;
  }
  public function getSessionTime(){
    return $this->sessionTime;
  }
  public function getSessionDate(){
    return $this->sessionDate;
  }
  public function getVenue(){
    return $this->venue;
  }
  public function getTicketPrice(){
    return $this->ticketPrice;
  }
  public function setTicketId($ticketId){
    $this->ticketId = $ticketId;
  }
  public function setArtistName($artistName){
    $this->artistName = $artistName;
  }
  public function setSessionTime($sessionTime){
    $this->sessionTime = $sessionTime;
  }
  public function setSessionDate($sessionDate){
    $this->sessionDate = $sessionDate;
  }
  public function setVenue($venue){
    $this->venue = $venue;
  }
  public function setTicketPrice($ticketPrice){
    $this->ticketPrice = $ticketPrice;
  }

  public function jsonSerialize():mixed
  {
    $vars=get_object_vars($this);
            return $vars;
  }


}