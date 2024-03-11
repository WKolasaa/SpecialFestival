<?php
namespace App\Models;

class Artist implements \JsonSerializable{
  private $artistId;
  private $artistName;
  private $style;
  private $participationDate;

  public function __construct($artistId, $artistName, $style, $participationDate) {
      $this->artistId = $artistId;
      $this->artistName = $artistName;
      $this->style = $style;
      $this->participationDate = $participationDate;
  }

  public function getArtistId(){
    return $this->artistId;
  }
  public function getArtistName(){
    return $this->artistName;
  }
  public function getStyle(){
    return $this->style;
  }
  public function getParticipationDate(){
    return $this->participationDate;
  }
  public function setArtistId($artistId){
    $this->artistId = $artistId;
  }
  public function setArtistName($artistName){
    $this->artistName = $artistName;
  }
  public function setStyle($style){
    $this->style = $style;
  }
  public function setParticipationDate($participationDate){
    $this->participationDate = $participationDate;
  }

  public function jsonSerialize():mixed
  {
    $vars=get_object_vars($this);
    return $vars;

  }
}