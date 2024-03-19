<?php

namespace App\Controllers;

class DanceEventController
{

   public function index()
   {
      include '../views/DanceView/overview.php';
   }
   public function agenda()
   {
      include '../views/DanceView/agenda.php';
   }
   public function session()
   {
      include '../views/DanceView/session.php';
   }



}

