<?php

namespace App\Models;

class HomeCMSEntry
{
    public $id;
    public $content_name;
    public $content_type; // 'TEXT' or 'IMAGE'
    public $content;

    public function __construct($id, $content_name, $content_type, $content)
    {
        $this->id = $id;
        $this->content_name = $content_name;
        $this->content_type = $content_type;
        $this->content = $content;
    }

    //private and getter and setters
}
