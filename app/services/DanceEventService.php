<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\Artist;
use App\Models\DanceOverview;
use App\Models\Session;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Repositories\DanceEventRepository;
use App\Repositories\TicketRepository;
use DateTime;
use Exception;

class DanceEventService
{

    private $danceEventRepository;
    private $ticketRepository;

    function __construct()
    {
        $this->danceEventRepository = new DanceEventRepository();
        $this->ticketRepository = new TicketRepository();
    }

    public function getAllAgendas()
    {
        return $this->danceEventRepository->getAllAgendas();
    }

    public function getAllSessions()
    {
        return $this->danceEventRepository->getAllSessions();
    }

    public function getDanceOverviewsByArtist()
    {
        // Get all artists and dance overviews
        $artists = $this->getAllArtists();
        $danceOverviews = $this->getAllDanceOverviews();

        // Filter the dance overviews
        $filteredDanceOverviews = array_filter($danceOverviews, function ($overview) use ($artists) {
            // Check if the overview's header matches any artist name
            foreach ($artists as $artist) {
                if ($overview->getHeader() == $artist->getArtistName()) {
                    // If a match is found, return true
                    return true;
                }
            }
            // If no match is found, return false
            return false;
        });
        // Return the filtered dance overviews
        return $filteredDanceOverviews;
    }

    public function getAllArtists()
    {
        return $this->danceEventRepository->getAllArtists();
    }

    public function getAllDanceOverviews()
    {
        // var_dump($this->danceEventRepository->getAllDanceOverviews());
        return $this->danceEventRepository->getAllDanceOverviews();
    }


    ////////////////update////////////////////////////

    public function updateArtist(array $artistData)
    {
        try {
            $artist = $this->convertArrayToArtist($artistData);
            $this->danceEventRepository->updateArtist($artist);
        } catch (Exception $e) {
            error_log("An error occurred while updating artist data: " . $e->getMessage());
            throw new Exception("An error occurred while updating artist data.");
        }
    }

    private function convertArrayToArtist(array $artistData): Artist
    {
        // var_dump($artistData);

        // $requiredKeys = ['artistId', 'artistName', 'style', 'participationDate'];
        $requiredKeys = ['artistName', 'style', 'description', 'title', 'participationDate', 'imageName'];
        $artistId = isset($artistData['artistId']) ? $artistData['artistId'] : null;

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $artistData)) {
                throw new Exception("Missing key in artist data: $key");
            }
        }
        $artist = new Artist(
            $artistId,
            $artistData['artistName'],
            $artistData['style'],
            $artistData['description'],
            $artistData['title'],
            $artistData['participationDate'],
            $artistData['imageName']
        );
        return $artist;
    }

    public function updateAgenda(array $agendaArray)
    {
        try {
            $agenda = $this->convertArrayToAgenda($agendaArray);
            $this->danceEventRepository->updateAgenda($agenda);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating agenda data: " . $e->getMessage());

        }

    }

    private function convertArrayToAgenda(array $agendaData): Agenda
    {
        $requiredKeys = ['artistName', 'eventDay', 'eventDate', 'eventTime', 'durationMinutes', 'sessionPrice', 'sessionsAvailable', 'venueAddress'];
        $agendaId = isset($agendaData['agendaId']) ? $agendaData['agendaId'] : null;


        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $agendaData)) {
                throw new Exception("Missing key in agenda data: $key");
            }
        }
        $agenda = new Agenda(
        // $agendaData['agendaId'],
            $agendaId,
            $agendaData['artistName'],
            $agendaData['eventDay'],
            $agendaData['eventDate'],
            $agendaData['eventTime'],
            $agendaData['durationMinutes'],
            $agendaData['sessionPrice'],
            $agendaData['sessionsAvailable'],
            $agendaData['venueAddress']
        );
        return $agenda;
    }


    public function updateSession(array $sessionArray)
    {
        try {
            $session = $this->convertArrayToSession($sessionArray);
            $this->danceEventRepository->updateSession($session);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating session data: " . $e->getMessage());
        }
    }

    private function convertArrayToSession(array $sessionData): Session
    {
        // echo "sessionData: ".$sessionData['sessionId'];
        $requiredKeys = ['artistName', 'sessionDate', 'venue', 'sessionPrice', 'sessionType'];
        $sessionId = isset($sessionData['sessionId']) ? $sessionData['sessionId'] : null;
        $startSession = isset($sessionData['startSession']) ? $sessionData['startSession'] : null;
        $endSession = isset($sessionData['endSession']) ? $sessionData['endSession'] : null;

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $sessionData)) {
                throw new Exception("Missing key in session data: $key");
            }
        }

        $session = new Session(
            $sessionId,
            $sessionData['artistName'],
            $startSession,
            $sessionData['sessionDate'],
            $sessionData['venue'],
            $sessionData['sessionPrice'],
            $sessionData['sessionType'],
            $endSession
        );

        return $session;
    }

    public function updateDanceOverview(array $danceOverviewData)
    {
        try {
            $danceOverview = $this->convertArrayToDanceOverview($danceOverviewData);
            $this->danceEventRepository->updateDanceOverview($danceOverview);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating dance overview data: " . $e->getMessage());
        }
    }

    private function convertArrayToDanceOverview(array $danceOverviewData): DanceOverview
    {
        $requiredKeys = ['text'];
        $id = isset($danceOverviewData['id']) ? $danceOverviewData['id'] : null;
        $header = isset($danceOverviewData['header']) ? $danceOverviewData['header'] : null;
        $subHeader = isset($danceOverviewData['subHeader']) ? $danceOverviewData['subHeader'] : null;
        $imageName = isset($danceOverviewData['imageName']) ? $danceOverviewData['imageName'] : null;
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $danceOverviewData)) {
                throw new Exception("Missing key in dance overview data: $key");
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

    public function deleteArtist($artistId)
    {
        try {
            $this->danceEventRepository->deleteArtist($artistId);

        } catch (Exception $e) {
            throw new Exception("An error occurred while  deleting artist data. " . $e->getMessage());

        }
    }

    public function getArtistById($artistId)
    {
        try {
            $artist = $this->danceEventRepository->getArtistById($artistId);
            return $artist;
        } catch (Exception $e) {
            throw new Exception("An error occurred while retrieving artist data: " . $e->getMessage());
        }
    }

    public function getDanceOverviewById($id)
    {
        try {
            $danceOverview = $this->danceEventRepository->getDanceOverviewById($id);
            return $danceOverview;
        } catch (Exception $e) {
            throw new Exception("An error occurred while retrieving dance overview data: " . $e->getMessage());
        }
    }

    public function deleteAgenda(array $agendaArray)
    {
        try {
            $agenda = $this->convertArrayToAgenda($agendaArray);
            $this->danceEventRepository->deleteAgenda($agenda);
        } catch (Exception $e) {
            throw new Exception("An error occurred while deleting agenda data: " . $e->getMessage());

        }
    }

    public function deleteSession(array $sessionArray)
    {
        try {
            $session = $this->convertArrayToSession($sessionArray);
            $this->danceEventRepository->deleteSession($session);
        } catch (Exception $e) {

            throw new Exception("An error occurred while deleting session data: " . $e->getMessage());

        }
    }

    public function deleteDanceOverview($danceOverviewId)
    {
        try {
            // $danceOverview = $this->convertArrayToDanceOverview($danceOverviewData);
            $this->danceEventRepository->deleteDanceOverview($danceOverviewId);
        } catch (Exception $e) {
            throw new Exception("An error occurred while deleting dance overview data: " . $e->getMessage());

        }
    }

    public function addArtist(Artist $artist)
    {
        try {
            $this->danceEventRepository->addArtist($artist);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding artist data: " . $e->getMessage());

        }
    }

    public function addEvent(array $agendaData)
    {
        try {
            $agenda = $this->convertArrayToAgenda($agendaData);
            $this->danceEventRepository->addEvent($agenda);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding agenda data: " . $e->getMessage());

        }
    }

    public function addSession(array $sessionData)
    {
        try {
            $session = $this->convertArrayToSession($sessionData);
            // var_dump($session);
            $this->danceEventRepository->addSession($session);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add session: ' . $e->getMessage()]);
        }
    }

    public function addDanceOverview(DanceOverview $danceOverview)
    {
        try {
            $this->danceEventRepository->addDanceOverview($danceOverview);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding dance overview data: " . $e->getMessage());
        }
    }

    public function addTicket(array $ticketData)
    {
        try {
            $ticket = $this->convertSessionToTicket($ticketData);
            $this->ticketRepository->addTicket($ticket);
        } catch (Exception $e) {
            error_log("An error occurred while adding ticket data: " . $e->getMessage());
            throw new Exception("An error occurred while adding ticket data.");
        }
    }

    public function convertSessionToTicket(array $sessionData): Ticket
    {

        $requiredKeys = ['artistName', 'venue', 'sessionPrice', 'startSession', 'endSession'];
        $sessionId = isset($sessionData['sessionId']) ? $sessionData['sessionId'] : null;
        $ticketDescription = isset($sessionData['description']) ? $sessionData['description'] : '';
        $startDateTime = new DateTime($sessionData['sessionDate'] . ' ' . $sessionData['startSession']);
        $endDateTime = new DateTime($sessionData['sessionDate'] . ' ' . $sessionData['endSession']);

        // Check if all required keys are present
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $sessionData)) {
                throw new Exception("Missing key in session data: $key");
            }
        }

        // Use the Dance case of the TicketType enum
        $ticketType = TicketType::Dance;

        // Create a new Ticket object using the session data
        $ticket = new Ticket(
            $sessionId,
            $sessionData['artistName'],  // event_name
            $ticketType,                 // ticket_Type
            'DANCE EVENT',               // ticket_name
            $sessionData['venue'],       // location
            $ticketDescription,          // description
            $sessionData['sessionPrice'],// price
            $startDateTime,              // start_date
            $endDateTime,                // end_date
            20
        );
        return $ticket;
    }

}