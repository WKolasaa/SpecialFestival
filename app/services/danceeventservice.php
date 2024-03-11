<?php
namespace App\Services;

use App\Models\Artist;
use App\Repositories\DanceEventRepository;
use App\Models\Agenda;
use App\Models\Ticket;

class DanceEventService{

private $danceEventRepository;

  function __construct()
  {
      $this->danceEventRepository = new DanceEventRepository();
  }

 public function getAllArtists(){
   return $this->danceEventRepository->getAllArtists();
 }  
    public function getAllAgendas(){
    return $this->danceEventRepository->getAllAgendas();
    }
    public function getAllTickets(){
    return $this->danceEventRepository->getAllTickets();
    }


   ////////////////update////////////////////////////

    public function updateArtist(array $artistData){
      try{
        $artist = $this->convertArrayToArtist($artistData);
        $this->danceEventRepository->updateArtist($artist);
      }catch(\Exception $e){
        echo "An error occurred while updating artist data.";
        throw $e;
      }
    }

    public function updateAgenda(array $agendaArray){
      try{
        $agenda = $this->convertArrayToAgenda($agendaArray);
        $this->danceEventRepository->updateAgenda($agenda);
      }catch(\Exception $e){
        echo "An error occurred while updating agenda data.8onim";
        throw $e;
      }

    }

    public function updateTicket(array $ticketArray){
      try{
        $ticket = $this->convertArrayToTickets($ticketArray);
        $this->danceEventRepository->updateTicket($ticket);
      }catch(\Exception $e){
        echo "An error occurred while updating ticket data.";
        throw $e;
      }
    }
//////////////////////delete///////////////////////////
    public function deleteArtist(array $artistArray){
    try{
      $artist = $this->convertArrayToArtist($artistArray); 
      $this->danceEventRepository->deleteArtist($artist);

      }catch(\Exception $e){
        echo "An error occurred while deleting artist data.";
        throw $e;
      }
    }

    public function deleteAgenda(array $agendaArray){
      try{
        var_dump($agendaArray);
        $agenda = $this->convertArrayToAgenda($agendaArray);
        $this->danceEventRepository->deleteAgenda($agenda);
      }catch(\Exception $e){
        echo "An error occurred while deleting agenda data.";

        throw $e;
      }
    }
      public function deleteTicket(array $ticketArray){
      try{
        $ticket = $this->convertArrayToTickets($ticketArray);
        $this->danceEventRepository->deleteTicket($ticket);
      }catch(\Exception $e){

        echo "An error occurred while deleting ticket data.";
        throw $e;
      }
    }

    public function addArtist(array $artistData){
      try{
        $artist = $this->convertArrayToArtist($artistData);
        $this->danceEventRepository->addArtist($artist);
      }catch(\Exception $e){
        echo "An error occurred while adding artist data.";
        throw $e;
      }
    }

    public function addEvent(array $agendaData){
      try{
        $agenda = $this->convertArrayToAgenda($agendaData);
        $this->danceEventRepository->addEvent($agenda);
      }catch(\Exception $e){
        echo "An error occurred while adding agenda data.";
        throw $e;
      }
    }

    public function addTicket(array $ticketData){
      try{
        $ticket = $this->convertArrayToTickets($ticketData);
        $this->danceEventRepository->addTicket($ticket);
      }catch(\Exception $e){
        echo "An error occurred while adding ticket data.";
        throw $e;
      }
    }



    private function convertArrayToArtist(array $artistData):Artist
    {

      // $requiredKeys = ['artistId', 'artistName', 'style', 'participationDate'];
      $requiredKeys = ['artistName', 'style', 'participationDate'];
      $artistId=isset($artistData['artistId']) ? $artistData['artistId'] : null;

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $artistData)) {
                throw new \Exception("Missing key in artist data: $key");
            }
        }
        $artist = new Artist(
            // $artistData['artistId'],
            $artistId,
            $artistData['artistName'],
            $artistData['style'],
            $artistData['participationDate']
        );
        return $artist;
    }

    private function convertArrayToAgenda(array $agendaData):Agenda
    {   
      // $requiredKeys=['agendaId', 'artistName', 'eventDay', 'eventDate', 'eventTime', 'durationMinutes', 'ticketPrice', 'ticketsAvailable', 'venueAddress'];
      $requiredKeys=['artistName', 'eventDay', 'eventDate', 'eventTime', 'durationMinutes', 'ticketPrice', 'ticketsAvailable', 'venueAddress'];
      $agendaId=isset($agendaData['agendaId']) ? $agendaData['agendaId'] : null;

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $agendaData)) {
                throw new \Exception("Missing key in agenda data: $key");
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
            $agendaData['ticketPrice'],
            $agendaData['ticketsAvailable'],
            $agendaData['venueAddress']
        );
        return $agenda;
    }

    private function convertArrayToTickets(array $ticketData):Ticket
    {
      // $requiredKeys=['ticketId', 'artistName', 'sessionTime', 'sessionDate', 'venue', 'ticketPrice'];
      $requiredKeys=['artistName', 'sessionTime', 'sessionDate', 'venue', 'ticketPrice'];
      $ticketId=isset($ticketData['ticketId']) ? $ticketData['ticketId'] : null;

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $ticketData)) {
                throw new \Exception("Missing key in ticket data: $key");
            }
        }
        $ticket = new Ticket(
            // $ticketData['ticketId'],
            $ticketId,
            $ticketData['artistName'],
            $ticketData['sessionTime'],
            $ticketData['sessionDate'],
            $ticketData['venue'],
            $ticketData['ticketPrice']
        );
        return $ticket;
    }

}