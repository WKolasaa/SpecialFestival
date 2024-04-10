<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Exception;

class TicketService
{

    private $ticketRepository;

    function __construct()
    {
        $this->ticketRepository = new TicketRepository();
    }

    public function getAllTickets()
    {
        return $this->ticketRepository->getAllTickets();
    }


    private function convertArrayToTicket(array $ticketData): Ticket
    { //change the array to object
        $requiredKeys = ['event_name', 'ticket_Type', 'ticket_name', 'location', 'description', 'price', 'start_date', 'end_date'];
        $id = isset($ticketData['id']) ? $ticketData['id'] : null;
        $event_name = isset($ticketData['event_name']) ? $ticketData['event_name'] : null;
        $ticket_Type = isset($ticketData['ticket_Type']) ? $ticketData['ticket_Type'] : null;
        $ticket_name = isset($ticketData['ticket_name']) ? $ticketData['ticket_name'] : null;
        $location = isset($ticketData['location']) ? $ticketData['location'] : null;
        $description = isset($ticketData['description']) ? $ticketData['description'] : null;
        $price = isset($ticketData['price']) ? $ticketData['price'] : null;
        $start_date = isset($ticketData['start_date']) ? $ticketData['start_date'] : null;
        $end_date = isset($ticketData['end_date']) ? $ticketData['end_date'] : null;
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $ticketData)) {
                throw new Exception("Missing key in ticket data: $key");
            }
        }
        $ticket = new Ticket(
            $id,
            $event_name,
            $ticket_Type,
            $ticket_name,
            $location,
            $description,
            $price,
            $start_date,
            $end_date
        );
        return $ticket;

    }

}

/*
  private function convertArrayToDanceOverview(array $danceOverviewData): DanceOverview
  {
    $requiredKeys = [ 'text'];
    $id= isset($danceOverviewData['id']) ? $danceOverviewData['id'] : null;
    $header= isset($danceOverviewData['header']) ? $danceOverviewData['header'] : null;
    $subHeader= isset($danceOverviewData['subHeader']) ? $danceOverviewData['subHeader'] : null;
    $imageName= isset($danceOverviewData['imageName']) ? $danceOverviewData['imageName'] : null;
    foreach ($requiredKeys as $key) {
      if (!array_key_exists($key, $danceOverviewData)) {
        throw new \Exception("Missing key in dance overview data: $key");
      }
    }
    $danceOverview = new DanceOverview(
      $id,
      $header,
      $subHeader,
      $danceOverviewData['text'],
      $danceOverviewData['imageName']
    );
    return $danceOverview;
  }
*/ 