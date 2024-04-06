<?php
namespace App\Models;

class HistoryCMSEntry {
  public $id;
  public $page_name;
  public $entry_name;
  public $entry_type;

  public $content;

    public function __construct($id, $page_name, $entry_name, $entry_type, $content) {
      $this->id = $id;
      $this->page_name = $page_name;
      $this->entry_name = $entry_name;
      $this->entry_type = $entry_type;  
      $this->content = $content;
    }
}


