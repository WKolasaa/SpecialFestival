<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketType;
use App\Repositories\HistoryAdminRepository;
use App\Repositories\TicketRepository;
use DateTime;
use Exception;

class HistoryAdminService
{

    private $historyAdminRepository;
    private $ticketRepository;

    function __construct()
    {
        $this->ticketRepository = new TicketRepository();
        $this->historyAdminRepository = new HistoryAdminRepository();
    }

    public function getAll()
    {
        return $this->historyAdminRepository->getAll();
    }

    public function getContent($page_name, $entry_name)
    {
        return $this->historyAdminRepository->getContent($page_name, $entry_name);
    }

    public function updateEntry($entry_id, $content)
    {
        $this->historyAdminRepository->updateEntry($entry_id, $content);
    }

    public function getEntryContent($entry_id)
    {
        return $this->historyAdminRepository->getEntryContent($entry_id);
    }

    public function addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour)
    {
        $this->historyAdminRepository->addTimeslot($day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
    }

    public function getAllTimeslots()
    {
        return $this->historyAdminRepository->getAllTimeslots();
    }

    public function updateTimeslot($id, $day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour)
    {
        return $this->historyAdminRepository->updateTimeslot($id, $day, $start_time, $end_time, $english_tour, $dutch_tour, $chinese_tour);
    }

    public function getTimeslotById($id)
    {
        return $this->historyAdminRepository->getTimeslotById($id);
    }

    public function deleteTimeslot($id)
    {
        return $this->historyAdminRepository->deleteTimeslot($id);
    }

    public function addTicket(array $ticketData)
    {
        try {
            //transforms the associative array $ticketData into a Ticket object
            $ticket = $this->convertHistoryTicketToTicket($ticketData);
            //Passes the newly created Ticket object to the repository for storage
            $this->ticketRepository->addTicket($ticket);
        } catch (Exception $e) {
            error_log("An error occurred while adding ticket data: " . $e->getMessage());
            throw new Exception("An error occurred while adding ticket data.");
        }
    }


    public function convertHistoryTicketToTicket(array $historyTicketData): Ticket
    {

        $requiredKeys = ['event_name', 'ticket_name', 'location', 'description', 'price', 'start_date', 'end_date'];

        // Check if all required keys are present in the input array
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $historyTicketData)) {
                throw new Exception("Missing key in history ticket data: $key");
            }
        }

        // Retrieves a timeslot_id if present. Otherwise, sets it to null
        $ticketId = $historyTicketData['timeslot_id'] ?? null;

        // Convert date strings to DateTime objects
        $startDateTime = new DateTime($historyTicketData['start_date']);
        $endDateTime = new DateTime($historyTicketData['end_date']);

        // Instantiate and return a new Ticket object
        $ticket = new Ticket(
            $ticketId,
            $historyTicketData['event_name'],
            TicketType::History,
            $historyTicketData['ticket_name'],
            $historyTicketData['location'],
            $historyTicketData['description'],
            (int)$historyTicketData['price'],
            $startDateTime,
            $endDateTime,
            20
        );

        return $ticket;
    }

}