<?php
namespace App\Models;

class HistoryCMSEntry {
    private $id;
    private $page_name;
    private $entry_name;
    private $entry_type;
    private $content;

    // empty constructor
    public function __construct() {
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getPageName() {
        return $this->page_name;
    }

    public function getEntryName() {
        return $this->entry_name;
    }

    public function getEntryType() {
        return $this->entry_type;
    }

    public function getContent() {
        return $this->content;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setPageName($page_name) {
        $this->page_name = $page_name;
    }

    public function setEntryName($entry_name) {
        $this->entry_name = $entry_name;
    }

    public function setEntryType($entry_type) {
        $this->entry_type = $entry_type;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
