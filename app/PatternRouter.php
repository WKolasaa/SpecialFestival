<?php
//test

namespace App;

use Exception;

class PatternRouter
{
    public function route($uri)
    {
        // check if we are requesting an api route
        $api = false;
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            $api = true;
        }

        // set default controller/method
        $defaultcontroller = 'home';
        $defaultmethod = 'index';

        // ignore query parameters
        $uri = $this->stripParameters($uri);

        // read controller/method names from URL
        $explodedUri = explode('/', $uri);

        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = $defaultcontroller;
        }
        $controllerName = "App\\Controllers\\" . ucfirst($explodedUri[0]) . "Controller";

        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = $defaultmethod;
        }
        $methodName = $explodedUri[1];

        // load the file with the controller class
        $filename = __DIR__ . '/controllers/' . ucfirst($explodedUri[0]) . 'Controller.php';
        if ($api) {
            $filename = __DIR__ . '/api/controllers/' . ucfirst($explodedUri[0]) . 'Controller.php';
        }
        if (file_exists($filename)) {
            require $filename;
            // echo $filename;

        } else {
            http_response_code(404);
            die();
        }

        // dynamically call relevant controller method
        if (!class_exists($controllerName)) {
            echo "Controller class does not exist: $controllerName";

            http_response_code(404);
            die();
        }

        try {
            $controllerObj = new $controllerName();
            $controllerObj->{$methodName}();

        } catch (Exception $e) {
            // Log or handle the error more gracefully
            http_response_code(500);
            die();
        }
    }

    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }
}
