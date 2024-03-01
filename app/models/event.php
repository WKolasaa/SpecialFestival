<?php
namespace App\Models;

class Event{
  public $event_date;
  public $day;
  public $time;
  public $location;
  public $event_type; // check if it is needed

    public function __construct($event_date, $day, $time, $location, $event_type) {
        $this->event_date = $event_date;
        $this->day = $day;
        $this->time = $time;
        $this->location = $location;
        $this->event_type = $event_type;
    }
}


