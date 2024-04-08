<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController
{
  private $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }


  public function index()
  {
    try {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: Content-Type");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
      header("Content-Type: application/json");
      session_start();
      if (isset($_SESSION['user'])) {
        $user=$this->userService->getUserById($_SESSION['user']->getId());
        echo json_encode($user);
      } else {
        echo json_encode(['error' => 'User not logged in.']);
      }


    } catch (\Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

public function update()
{
    header("Content-Type: application/json");
    $jsonData = file_get_contents('php://input');
    $decodedData = json_decode($jsonData, true);

    $sanitizedData = $this->sanitizeUserData($decodedData);

    try {
         $updateResult=$this->userService->updateUser($sanitizedData);
         if($updateResult){
            echo json_encode(['success' => 'User updated successfully']);
          }else{
            echo json_encode(['error' => 'No rows were affected.']);
          }
        
         
    } catch (\Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

public function delete()
{
    header("Content-Type: application/json");
    $jsonData = file_get_contents('php://input');
    $decodedData = json_decode($jsonData, true);

    try {
         $deleteResult=$this->userService->deleteUser($decodedData['id']);
         session_start();
         session_unset();
         session_destroy();
         if($deleteResult){
            echo json_encode(['success' => 'User deleted successfully']);
          }else{
            echo json_encode(['error' => 'No rows were affected.']);
          }
        
         
    } catch (\Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}


  public function sanitizeUserData($data) //This helps prevent XSS (Cross-Site Scripting) attacks.
  {
    // var_dump($data);
    
    $data['id']=filter_var($data['id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['userRole']=filter_var($data['userRole'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['userName'] = filter_var($data['userName'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['firstName'] = filter_var($data['firstName'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['lastName'] = filter_var($data['lastName'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['password'] = filter_var($data['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $data['phoneNumber'] = filter_var($data['phoneNumber'], FILTER_SANITIZE_SPECIAL_CHARS); 
    if (isset($data['photo']) && !empty($data['photo'])) {
      $data['photo'] = filter_var($data['photo'], FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
      $data['photo'] = null;

    }
    return $data;
  }
}