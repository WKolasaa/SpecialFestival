<?php

namespace App\Models;

class DanceEvent extends Event{

  // TODO: Add the properties for the DanceEvent class and change the attributes to private
  public $event_id;
  public $performers;
  public $event_duration_minutes;
  public $tickets_available;
  public $ticket_price;
  public $additional_info;
  public $artist_styles;
  public $event_session;  
  public $venue_address;
  public function __construct($event_id,$event_date, $day, $time, $venue, $performers,$event_session, $event_duration_minutes,  $tickets_available, $ticket_price, $additional_info,$venue_address, $artist_styles) {
      parent::__construct($event_date, $day, $time, $venue, 'Dance');
      $this->event_id = $event_id;
      $this->performers = $performers;
      $this->event_session = $event_session;
      $this->event_duration_minutes = $event_duration_minutes;
      $this->tickets_available = $tickets_available;
      $this->ticket_price = $ticket_price;
      $this->additional_info = $additional_info;
      $this->venue_address = $venue_address;
      $this->artist_styles = $artist_styles;
  }

  public function getPerformers(){
    return $this->performers;
  }
  public function getEventSession(){
    return $this->event_session;
  }
  public function getEventDurationMinutes(){
    return $this->event_duration_minutes;
  }
  
  public function getTicketsAvailable(){
    return $this->tickets_available;
  }
  public function getTicketPrice(){
    return $this->ticket_price;
  }
  public function getAdditionalInfo(){
    return $this->additional_info;
  }
  public function getVenueAddress(){
    return $this->venue_address;
  }
  public function getArtistStyles(){
    return $this->artist_styles;
  }
public function getEventId(){
    return $this->event_id;
  }
  public function setEventId($event_id){
    $this->event_id = $event_id;
  }

  public function setPerformers($performers){
    $this->performers = $performers;
  }
  public function setEventSession($event_session){
    $this->event_session = $event_session;
  }
  public function setEventDurationMinutes($event_duration_minutes){
    $this->event_duration_minutes = $event_duration_minutes;
  }
  
  public function setTicketsAvailable($tickets_available){
    $this->tickets_available = $tickets_available;
  }
  public function setTicketPrice($ticket_price){
    $this->ticket_price = $ticket_price;
  }
  public function setAdditionalInfo($additional_info){
    $this->additional_info = $additional_info;
  }
  public function setVenueAddress($venue_address){
    $this->venue_address = $venue_address;
  }
  public function setArtistStyles($artist_styles){
    $this->artist_styles = $artist_styles;
  }

}