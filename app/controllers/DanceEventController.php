<?php

namespace App\Controllers;

use App\Services\DanceEventService;

class DanceEventController
{
    private DanceEventService $danceEventService;

    public function __construct()
    {
        $this->danceEventService = new DanceEventService();
    }

    public function index()
    {
        $overviews = $this->danceEventService->getAllDanceOverviews();
        include '../views/DanceView/overview.php';
    }

    public function artist()
    {
        $artists = $this->danceEventService->getDanceOverviewsByArtist();
        include '../views/DanceView/artist.php';
    }

    public function agenda()
    {
        $event = $this->danceEventService->getAllAgendas();
        include '../views/DanceView/agenda.php';
    }

    public function session()
    {
        $session = $this->danceEventService->getAllSessions();
        include '../views/DanceView/session.php';
    }

}

