<?php
namespace App\Models;

use App\Models\UserRolesEnum;

class User implements \JsonSerializable{

    private  $id;
    private  $username;
    private  $password;
    private  $userRole;

    public function __construct( $id, $username, $password,$userRole,$registratedDate){
    
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->userRole = $userRole;
        $this->$registratedDate = $registrationDate;
    }

    private $resgisteredDate; //dateTime
    private $firstName;
    private $lastName;
    private $email;
    private $photo;

    public function __construct()
    {

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
  
       public function jsonSerialize():mixed
        {
            $vars=get_object_vars($this);
            return $vars;
        }
    public function getResgisteredDate() {
        return $this->resgisteredDate;
    }
    public function setResgisteredDate($resgisteredDate) {
        $this->resgisteredDate = $resgisteredDate;
    }

    public function getFirstName() {
        return $this->firstName;
    }
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }



}
