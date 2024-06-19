<?php
namespace App\Models;

class HistoryTimeslot {
    private $id;
    private $day;
    private $start_time;
    private $end_time;
    private $english_tour;
    private $dutch_tour;
    private $chinese_tour;

    // empty constructor
    public function __construct() {
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getDay() {
        return $this->day;
    }

    public function getStartTime() {
        return $this->start_time;
    }

    public function getEndTime() {
        return $this->end_time;
    }

    public function getEnglishTour() {
        return $this->english_tour;
    }

    public function getDutchTour() {
        return $this->dutch_tour;
    }

    public function getChineseTour() {
        return $this->chinese_tour;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setDay($day) {
        $this->day = $day;
    }

    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    public function setEndTime($end_time) {
        $this->end_time = $end_time;
    }

    public function setEnglishTour($english_tour) {
        $this->english_tour = $english_tour;
    }

    public function setDutchTour($dutch_tour) {
        $this->dutch_tour = $dutch_tour;
    }

    public function setChineseTour($chinese_tour) {
        $this->chinese_tour = $chinese_tour;
    }
}
