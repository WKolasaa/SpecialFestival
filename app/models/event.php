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

    public function getEventDate(){
      return $this->event_date;
    }
    public function getDay(){
      return $this->day;
    }
    public function getTime(){
      return $this->time;
    }
    public function getLocation(){
      return $this->location;
    }
    public function getEventType(){
      return $this->event_type;
    }
    public function setEventDate($event_date){
      $this->event_date = $event_date;
    }
    public function setDay($day){
      $this->day = $day;
    }
    public function setTime($time){
      $this->time = $time;
    }
    public function setLocation($location){
      $this->location = $location;
    }
    public function setEventType($event_type){
      $this->event_type = $event_type;
    }
    


    
}


