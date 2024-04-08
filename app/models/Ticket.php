<?php
namespace App\Models;

use DateTime;

class Ticket implements \JsonSerializable
{

  public int $id;
  public string $event_name;
  public TicketType $ticket_Type;
  public string $ticket_name;
  public string $location;
  public string $description;
  public int $price;
  public DateTime $start_date;
  public DateTime $end_date;

  public int $cart_id;

  public function __construct(int $id, string $event_name, TicketType $ticket_Type, string $ticket_name, string $location,string $description, int $price, DateTime $start_date, DateTime $end_date)
  {
    $this->id = $id;
    $this->event_name = $event_name;
    $this->ticket_Type = $ticket_Type;
    $this->ticket_name = $ticket_name;
    $this->location = $location;
    $this->description = $description;
    $this->price = $price;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
  }

  public function jsonSerialize(): mixed
  {
    $vars = get_object_vars($this);
    return $vars;
  }

}