<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService {

    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }


    public function addUser($userName, $firstName, $lastName, $email, $password, $photo)
    {
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->addUser($userName, $firstName, $lastName, $email, $hashpassword, $photo);
    }

    public function loginByEmail($email, $password)
    {
        return $this->userRepository->loginByEmail($email, $password);
    }

    public function loginByUserName($userName, $password)
    {
        return $this->userRepository->loginByUserName($userName, $password);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function checkForUserName($userName)
    {
        return $this->userRepository->checkForUserName($userName);
    }

    public function checkForEmail($email){
        return $this->userRepository->checkForEmail($email);
    }


    public function updateUserByAdmin(array $userData)
    {
        try {
        $user = $this->convertArrayToUser($userData);
       //    echo "user data converted successfully". $user;
    
        $this->userRepository->updateUserByAdmin($user);
      
      
            } 
         catch (\Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \Exception('Error updating user information: ' . $e->getMessage());      
        }
    }

    public function deleteUserByAdmin(array $userData)
    {
        try {
            // var_dump($userData);
            $user = $this->convertArrayToUser($userData);
            var_dump($user);
            echo $user->getId(). "TEsting the user id";
        
            // Now you can pass $user to the repository layer for updating
            $this->userRepository->deleteUserByAdmin($user);
          
          
        } catch (\Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \Exception('Error deleting user information: ' . $e->getMessage());
        }
    }

    public function createUserByAdmin(array $userData)
    {
        try {
            $user = $this->convertArrayToUser($userData);
            // var_dump($user);
            $this->userRepository->createUserByAdmin($user);
        } catch (\Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \Exception('Error creating user: ' . $e->getMessage());
        }
    }
    

    private function convertArrayToUser(array $userData): User
    {
        // Ensure that all required keys are present in the array
        // $requiredKeys = ['id', 'username', 'userRole'];
        $requiredKeys = [ 'username', 'userRole'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $userData)) {
                throw new \Exception("Missing key in user data: $key");
            }
        }
         // Check if password is provided
        $password = isset($userData['password']) ? $userData['password'] : null;
        $id = isset($userData['id']) ? $userData['id'] : null;
        $firstName = isset($userData['firstName']) ? $userData['firstName'] : null;
        $lastName = isset($userData['lastName']) ? $userData['lastName'] : null;
        $email = isset($userData['email']) ? $userData['email'] : null;
        $photo = isset($userData['photo']) ? $userData['photo'] : null;


//    public function __construct($id, $username, $password,$userRole,$registeredDate, $firstName, $lastName, $email, $photo){

        // Create a User instance and set additional properties
        $user = new User(
            // $userData['id'],
            $id,
            $userData['username'],
             $password, // Password is not being updated, so set it to null
            $userData['userRole'],
            null, // Registration date is not being updated, so set it to null
             $userData['firstName'],
             $userData['lastName'],
             $userData['email'],
             $userData['photo']
            
        );

        return $user;
      

    }

}
