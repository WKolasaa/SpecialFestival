<?php
namespace App\Models;

class HomeCMSEntry {
    private $id;
    private $content_name;
    private $content_type; // 'TEXT' или 'IMAGE'
    private $content;

    // empty constructor
    public function __construct() {
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getContentName() {
        return $this->content_name;
    }

    public function getContentType() {
        return $this->content_type;
    }

    public function getContent() {
        return $this->content;
    }

    // setters
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setContentName($content_name) {
        $this->content_name = $content_name;
    }

    public function setContentType($content_type) {
        $this->content_type = $content_type;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
