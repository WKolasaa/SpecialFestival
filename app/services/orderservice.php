<?php
namespace App\Services;

use App\Repositories\TicketRepository;


class OrderService
{

  public $ticketRepository;

  function __construct()
  {

    $this->ticketRepository=new TicketRepository();
  }
  
  public function getAllTickets()
  {
   return $this->ticketRepository->getAllTickets();
  }



}