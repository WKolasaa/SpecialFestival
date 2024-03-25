<?php
namespace App\Services;

use App\Models\Artist;
use App\Repositories\DanceEventRepository;
use App\Models\Agenda;
use App\Models\Session;

class DanceEventService
{

  private $danceEventRepository;

  function __construct()
  {
    $this->danceEventRepository = new DanceEventRepository();
  }

  public function getAllArtists()
  {
    return $this->danceEventRepository->getAllArtists();
  }
  public function getAllAgendas()
  {
    return $this->danceEventRepository->getAllAgendas();
  }
  public function getAllSessions()
  {
    return $this->danceEventRepository->getAllSessions();
  }


  ////////////////update////////////////////////////

  public function updateArtist(array $artistData)
  {
    try {
      $artist = $this->convertArrayToArtist($artistData);
      $this->danceEventRepository->updateArtist($artist);
    } catch (\Exception $e) {
      error_log("An error occurred while updating artist data: " . $e->getMessage());
      throw new \Exception("An error occurred while updating artist data.");
    }
  }

  public function updateAgenda(array $agendaArray)
  {
    try {
      $agenda = $this->convertArrayToAgenda($agendaArray);
      $this->danceEventRepository->updateAgenda($agenda);
    } catch (\Exception $e) {
      echo "An error occurred while updating agenda data.";
      throw $e;
    }

  }

  public function updateSession(array $sessionArray)
  {
    try {
      $session = $this->convertArrayToSession($sessionArray);
      $this->danceEventRepository->updateSession($session);
    } catch (\Exception $e) {
      throw new \Exception("An error occurred while updating session data: " . $e->getMessage());
    }
  }
  //////////////////////delete///////////////////////////
  public function deleteArtist($artistId)
  {
    try {
      $this->danceEventRepository->deleteArtist($artistId);

    } catch (\Exception $e) {
      echo "An error occurred while deleting artist data.";
      throw $e;
    }
  }

  public function getArtistById($artistId)
  {
    try {
      $artist = $this->danceEventRepository->getArtistById($artistId);
      return $artist;
    } catch (\Exception $e) {
      throw new \Exception("An error occurred while retrieving artist data: " . $e->getMessage());
    }
  }

  public function deleteAgenda(array $agendaArray)
  {
    try {
      $agenda = $this->convertArrayToAgenda($agendaArray);
      $this->danceEventRepository->deleteAgenda($agenda);
    } catch (\Exception $e) {
      echo "An error occurred while deleting agenda data.";

      throw $e;
    }
  }
  public function deleteSession(array $sessionArray)
  {
    try {
      $session = $this->convertArrayToSession($sessionArray);
      $this->danceEventRepository->deleteSession($session);
    } catch (\Exception $e) {

      echo "An error occurred while deleting session data.";
      throw $e;
    }
  }

  public function addArtist(Artist $artist)
  {
    try {
      $this->danceEventRepository->addArtist($artist);
    } catch (\Exception $e) {
      throw new \Exception("An error occurred while adding artist data: " . $e->getMessage());

    }
  }

  public function addEvent(array $agendaData)
  {
    try {
      $agenda = $this->convertArrayToAgenda($agendaData);
      $this->danceEventRepository->addEvent($agenda);
    } catch (\Exception $e) {
      echo "An error occurred while adding agenda data.";
      throw $e;
    }
  }

  public function addSession(array $sessionData)
  {
    try {
      $session = $this->convertArrayToSession($sessionData);
      // var_dump($session);
      $this->danceEventRepository->addSession($session);
    } catch (\Exception $e) {
      throw new \Exception("An error occurred while adding session data: " . $e->getMessage());
    }
  }



  private function convertArrayToArtist(array $artistData): Artist
  {
    

    // $requiredKeys = ['artistId', 'artistName', 'style', 'participationDate'];
    $requiredKeys = ['artistName', 'style', 'description', 'title', 'participationDate', 'imageName'];
    $artistId = isset($artistData['artistId']) ? $artistData['artistId'] : null;

    foreach ($requiredKeys as $key) {
      if (!array_key_exists($key, $artistData)) {
        throw new \Exception("Missing key in artist data: $key");
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

  private function convertArrayToAgenda(array $agendaData): Agenda
  {
    $requiredKeys = ['artistName', 'eventDay', 'eventDate', 'eventTime', 'durationMinutes', 'sessionPrice', 'sessionsAvailable', 'venueAddress'];
    $agendaId = isset($agendaData['agendaId']) ? $agendaData['agendaId'] : null;

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
      $agendaData['sessionPrice'],
      $agendaData['sessionsAvailable'],
      $agendaData['venueAddress']
    );
    return $agenda;
  }

  private function convertArrayToSession(array $sessionData): Session
  {
    // echo "sessionData: ".$sessionData['sessionId'];
    $requiredKeys = ['artistName', 'startSession', 'sessionDate', 'venue', 'sessionPrice', 'sessionType', 'endSession'];
    $sessionId = isset($sessionData['sessionId']) ? $sessionData['sessionId'] : null;
    foreach ($requiredKeys as $key) {
      if (!array_key_exists($key, $sessionData)) {
        throw new \Exception("Missing key in session data: $key");
      }
    }

    $session = new Session(
      $sessionId,
      $sessionData['artistName'],
      $sessionData['startSession'],
      $sessionData['sessionDate'],
      $sessionData['venue'],
      $sessionData['sessionPrice'],
      $sessionData['sessionType'],
      $sessionData['endSession']
    );

    return $session;
  }

}