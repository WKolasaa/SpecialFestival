<?php
namespace App\Models;

use App\Models\UserRolesEnum;

class User implements \JsonSerializable{

    private  $id;
    private  $username;
    private  $password;
    private  $userRole;
    private $registrationDate; //dateTime

    public function __construct( $id, $username, $password,$userRole,$registrationDate){
    
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->userRole = $userRole;
        $this->registrationDate = $registrationDate;
    }


    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

   

    public function getUserRole() {
        return $this->userRole;
    }

    public function setUserRole(string $role)
    {
        // Convert database role string to UserRolesEnum constant
        switch ($role) {
            case 'EMPLOYEE':
                $this->userRole = UserRolesEnum::Employee;
                break;
            case 'CUSTOMER':
                $this->userRole = UserRolesEnum::Customer;
                break;
            case 'ADMINISTRATOR':
                $this->userRole = UserRolesEnum::Administrator;
                break;
            default:
                // Handle unknown role
                // For example, you could set it to a default role or throw an exception
                $this->userRole = UserRolesEnum::Customer;
                break;
        }
    }

        public function getRegisteredDate() {
            return $this->registrationDate;
        }
        public function setRegisteredDate($registrationDate) {
            $this->registrationDate = $registrationDate;
        }
        public function jsonSerialize():mixed
        {
            $vars=get_object_vars($this);
            return $vars;
        }

}
