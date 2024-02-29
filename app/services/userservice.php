<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService {

    private $userrepository;

    function __construct()
    {
        $this->userrepository = new UserRepository();
    }

    public function getAll()
    {
        return $this->userrepository->getAll();
    }

    public function addUser($userName, $firstName, $lastName, $email, $password, $photo)
    {
        $this->userrepository->addUser($userName, $firstName, $lastName, $email, $password, $photo);
    }

    public function loginByEmail($email, $password)
    {
        return $this->userrepository->loginByEmail($email, $password);
    }

    public function loginByUserName($userName, $password)
    {
        return $this->userrepository->loginByUserName($userName, $password);
    }

    public function getUserByEmail($email)
    {
        return $this->userrepository->getUserByEmail($email);
    }

    public function checkForUserName($userName)
    {
        return $this->userrepository->checkForUserName($userName);
    }

    public function checkForEmail($email){
        return $this->userrepository->checkForEmail($email);
    }
}

?>