<?php
namespace App\Models;

use DateTime;

class Ticket implements \JsonSerializable
{

  private int $id;
  private string $event_name;
  private TicketType $ticket_Type;
  private string $ticket_name;
  private string $location;
  private string $description;
  private int $price;
  private DateTime $start_date;
  private DateTime $end_date;

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
  public function getTicketId()
  {
    return $this->id;
  }

  public function getEventName()
  {
    return $this->event_name;
  }


  public function getTicketType(): TicketType
  {
    return $this->ticket_Type;
  }
  public function getTicketTypeAsString(): string
  {
    return match($this->ticket_Type) {
      TicketType::Dance => 'Dance',
      TicketType::Yummy => 'Yummy',
      TicketType::History => 'History',
    };
  }

  public function setTicketType(TicketType $ticket_Type): void
  {
    $this->ticket_Type = $ticket_Type;
  }

  public function getTicketName(): string
  {
    return $this->ticket_name;
  }

  public function setTicketName(string $ticket_name): void
  {
    $this->ticket_name = $ticket_name;
  }

  public function getLocation(): string
  {
    return $this->location;
  }

  public function setLocation(string $location): void
  {
    $this->location = $location;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function setDescription(string $description): void
  {
    $this->description = $description;
  }

  public function getPrice(): int
  {
    return $this->price;
  }

  public function setPrice(int $price): void
  {
    $this->price = $price;
  }

  public function getStartDate(): DateTime
  {
    return $this->start_date;
  }

  public function setStartDate(DateTime $start_date): void
  {
    $this->start_date = $start_date;
  }

  public function getEndDate(): DateTime
  {
    return $this->end_date;
  }

  public function setEndDate(DateTime $end_date): void
  {
    $this->end_date = $end_date;
  }



  public function jsonSerialize(): mixed
  {
    $vars = get_object_vars($this);
    return $vars;
  }

}