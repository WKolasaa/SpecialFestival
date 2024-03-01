<?php

namespace App\Models;

class DanceEvent extends Event{
  // TODO: Add the properties for the DanceEvent class and change the attributes to private
  public $performers;
  public $event_duration_minutes;
  public $capacity;
  public $tickets_available;
  public $ticket_price;
  public $additional_info;
  public $artist_styles;
  public $event_session;  
  public $venue_address;
  public function __construct($event_date, $day, $time, $venue, $performers,$event_session, $event_duration_minutes, $capacity, $tickets_available, $ticket_price, $additional_info,$venue_address, $artist_styles) {
      parent::__construct($event_date, $day, $time, $venue, 'Dance');
      $this->performers = $performers;
      $this->event_session = $event_session;
      $this->event_duration_minutes = $event_duration_minutes;
      $this->capacity = $capacity;
      $this->tickets_available = $tickets_available;
      $this->ticket_price = $ticket_price;
      $this->additional_info = $additional_info;
      $this->venue_address = $venue_address;
      $this->artist_styles = $artist_styles;
  }
}