<?php
//test

namespace App;

class PatternRouter
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

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
       
        } catch (\Exception $e) {
            // Log or handle the error more gracefully
            http_response_code(500);
            die();
        }
    }
}






















    // public function route($uri)
    // {
    //     switch ($uri) {
    //         case '':
    //             require  'controllers/HomeController.php';
    //            $controller = new \App\Controllers\HomeController();
    //             $controller->index();
    //             break;

    //         case 'progress':

    //             require 'controllers/progresstrackercontoller.php';
    //             $controller = new \App\Controllers\ProgressTrackerController();
    //             $controller->index();
    //             break;

    //         case 'blog':
    //             require 'controllers/blogcontroller.php';

    //             $controller = new \App\Controllers\BlogController();
    //             $controller->index();
    //             break;

    //         case 'login';
    //         require 'controllers/logincontroller.php';
    //         $controller = new \App\Controllers\LoginController();
    //         $controller->index();
    //             break;
    //         case 'signup';
    //         require 'controllers/signupcontroller.php';
    //         $controller = new \App\Controllers\SignUpController();
    //         $controller->index();
    //             break;

    //         default:
    //         echo '404 Error :)';
    //             break;
    //     }
    // }


/*public function route($uri)
    {
        // Map URI patterns to controller classes
        $controllerMap = [
            '' => 'HomeController',
            'progress' => 'ProgressTrackerController',
            'blog' => 'BlogController',
            'login' => 'LoginController',
        ];

        // Check if the URI pattern exists in the map
        if (array_key_exists($uri, $controllerMap)) {
            // Build the controller class name
            $controllerClassName = '\App\Controllers\\' . $controllerMap[$uri];

            // Include the controller file
            require "controllers/{$controllerMap[$uri]}.php";

            // Instantiate the controller and call the index method
            $controller = new $controllerClassName();
            $controller->index();
        } else {
            // Handle 404 Not Found
            echo '404 Error :)';
        }
    }*/

     // private function stripParameters($uri)
    // {
    //     if (str_contains($uri, '?')) {
    //         $uri = substr($uri, 0, strpos($uri, '?'));
    //     }
    //     return $uri;
    // }

    // public function route($uri)
    // {
    //     $uri = $this->stripParameters($uri);

    //     $explodedUri = explode('/', $uri);

    //     if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
    //         $explodedUri[0] = 'home';
    //     }
    //     $controllerName = "App\\Controllers\\" . $explodedUri[0] . "controller";

    //     if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
    //         $explodedUri[1] = 'index';
    //     }
    //     $methodName = $explodedUri[1];

    //     // Controller/method matching the URL not found
    //     if(!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
    //         http_response_code(404);
    //         return;
    //     }

    //     try {            
    //         $controllerObj = new $controllerName();
    //         $controllerObj->$methodName();
    //     } catch(\Error $e) {
    //         // For some reason the class/method doesn't work
    //         http_response_code(500);
    //     }
    // }