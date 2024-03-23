<?php
// Ask about the position of the code to the teacher. TODO:
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Methods: *");

// error_reporting(E_ALL);
// ini_set("display_errors", 1);


require '../vendor/autoload.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new App\PatternRouter();
$router->route($uri);
