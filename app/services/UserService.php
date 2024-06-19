<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserService
{

    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }


    public function addUser($userName, $firstName, $lastName, $email, $password, $photo, $phoneNumber)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->addUser($userName, $firstName, $lastName, $email, $hashPassword, $photo, $phoneNumber);
    }

    public function loginByEmail($email, $password)
    {
        return $this->userRepository->loginByEmail($email, $password);
    }

    public function loginByUserName($userName, $password): ?User
    {
        return $this->userRepository->loginByUserName($userName, $password);
    }

    public function getUserByEmail($email): ?User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }

    public function checkForUserName($userName)
    {
        return $this->userRepository->checkForUserName($userName);
    }

    public function checkForEmail($email)
    {
        return $this->userRepository->checkForEmail($email);
    }

    public function updateUser(array $userData)
    {
        try {
            $user = $this->convertArrayToUser($userData);
            // Check if the password has been hashed
            if (!password_verify($user->getPassword(), $userData['password'])) {
                // If the password hasn't been hashed, hash it
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            }
            return $this->userRepository->updateUser($user);
        } catch (Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new Exception('Error updating user information: ' . $e->getMessage());
        }

    }

    private function convertArrayToUser(array $userInfo): User
    {
        $requiredKeys = ['id', 'userName', 'password', 'firstName', 'lastName', 'email', 'phoneNumber'];
        $id = isset($userInfo['id']) ? $userInfo['id'] : null;
        $userRole = isset($userInfo['userRole']) ? $userInfo['userRole'] : null;
        $photo = isset($userInfo['photo']) ? $userInfo['photo'] : null;


        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $userInfo)) {
                throw new Exception("Missing key in user data: $key");
            }
        }
        $user = new User(
            $userInfo['id'],
            $userInfo['userName'],
            $userInfo['password'],
            $userRole,
            null,// Registration date is not being updated, so set it to null
            $userInfo['firstName'],
            $userInfo['lastName'],
            $userInfo['email'],
            $photo,
            $userInfo['phoneNumber']
        );
        return $user;

    }


    ///////////////////////////ADMIN////////////////////////

    public function deleteUser($userId)
    {
        try {
            return $this->userRepository->deleteUser($userId);
        } catch (Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new Exception('Error deleting user information: ' . $e->getMessage());
        }
    }

    public function updateUserByAdmin(array $userData)
    {
        try {
            $user = $this->convertArrayToUserByAdminSide($userData);

            $this->userRepository->updateUserByAdmin($user);


        } catch (Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new Exception('Error updating user information: ' . $e->getMessage());
        }
    }

    private function convertArrayToUserByAdminSide(array $userData): User
    {
        $requiredKeys = ['username', 'userRole'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $userData)) {
                throw new Exception("Missing key in user data: $key");
            }
        }
        // Check if password is provided
        $password = isset($userData['password']) ? $userData['password'] : null;
        $id = isset($userData['id']) ? $userData['id'] : null;
        //add the registration date
        $firstName = isset($userData['firstName']) ? $userData['firstName'] : null;
        $lastName = isset($userData['lastName']) ? $userData['lastName'] : null;
        $email = isset($userData['email']) ? $userData['email'] : null;
        $photo = isset($userData['photo']) ? $userData['photo'] : null;
        $phoneNumber = isset($userData['phoneNumber']) ? $userData['phoneNumber'] : null;

        $user = new User(
            $id,
            $userData['username'],
            $password, // Password is not being updated, so set it to null
            $userData['userRole'],
            null, // Registration date is not being updated, so set it to null
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['photo'],
            $userData['phoneNumber']
        );
        return $user;
    }

    public function deleteUserByAdmin(array $userData)
    {
        try {
            // var_dump($userData);
            $user = $this->convertArrayToUserByAdminSide($userData);

            // Now you can pass $user to the repository layer for updating
            $this->userRepository->deleteUserByAdmin($user);


        } catch (Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new Exception('Error deleting user information: ' . $e->getMessage());
        }
    }

    public function createUserByAdmin(array $userData)
    {
        try {
            $user = $this->convertArrayToUserByAdminSide($userData);
            // var_dump($user);
            $hashpassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($hashpassword);
            $this->userRepository->createUserByAdmin($user);
        } catch (Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new Exception('Error creating user: ' . $e->getMessage());
        }
    }

    public function updatePassword($password, $email)
    {
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->updatePassword($hashpassword, $email);
    }

}