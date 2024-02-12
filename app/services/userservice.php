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
}

?>