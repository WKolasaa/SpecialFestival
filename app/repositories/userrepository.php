<?php
namespace App\Repositories;
use App\Models\User;

use PDO;

class UserRepository extends Repository{

  public function getAll(){


    $sql= "SELECT id, userName, password, userRole FROM user";
    $rows=$this->executeQuery($sql);

    if (!$rows) {
      echo "No users found.";
      return [];
    }
   // echo "query works successfully";
    return $this->mapToUserObjects($rows);

  }

  private function mapToUserObjects($rows)
    {
        $users = [];

        foreach ($rows as $row) {
            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($row['userName']);
            $user->setPassword($row['password']);
            $user->setUserRole( $row['userRole']);
    
            $users[] = $user;
        }

        return $users;
    }

  private function executeQuery($sql)
  {
      try {
          $statement = $this->connection->prepare($sql);
          $statement->execute();
          return $statement->fetchAll(PDO::FETCH_ASSOC);
      } catch (\PDOException $e) {
          throw new \PDOException("Query execution failed: " . $e->getMessage());
      }
  }

  public function addUser($userName, $firstName, $lastName, $email, $password, $photo)
  {
      $sql = "INSERT INTO user (userName, firstName, lastName, email, password, photo) VALUES (:userName, :firstName, :lastName, :email, :password, :photo)";
      $statement = $this->connection->prepare($sql);
      $statement->bindParam(':userName', $userName);
      $statement->bindParam(':firstName', $firstName);
      $statement->bindParam(':lastName', $lastName);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':password', $password);
      $statement->bindParam(':photo', $photo);
      try{
          $statement->execute();
      }catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
  }

    public function loginByEmail($email, $password)
    {
        $sql = "SELECT id, userName, password, userRole FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if (password_verify($password, $row['password'])) {
            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($row['userName']);
            $user->setPassword($row['password']);
            $user->setUserRole($row['userRole']);
            return $user;
        }
        return null;
    }

    public function loginByUserName($userName, $password)
    {
        $sql = "SELECT id, userName, password, userRole, registrationDate, email, firstName, lastName, photo FROM user WHERE userName = :userName";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':userName', $userName);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if (password_verify($password, $row['password'])) {
            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($row['userName']);
            $user->setPassword($row['password']);
            $user->setUserRole($row['userRole']);
            $user->setResgisteredDate($row['registrationDate']);
            $user->setEmail($row['email']);
            $user->setFirstName($row['firstName']);
            $user->setLastName($row['lastName']);
            $user->setPhoto($row['photo']);
            return $user;
        }
        return null;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, userName, password, userRole, registrationDate, email, firstName, lastName, photo FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['userName']);
        $user->setPassword($row['password']);
        $user->setUserRole($row['userRole']);
        $user->setResgisteredDate($row['registrationDate']);
        $user->setEmail($row['email']);
        $user->setFirstName($row['firstName']);
        $user->setLastName($row['lastName']);
        $user->setPhoto($row['photo']);
        return $user;
    }

    public function checkForUserName($userName)
    {
        $sql = "SELECT id FROM user WHERE userName = :userName";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':userName', $userName);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }
        return true;
    }

    public function checkForEmail($email)
    {
        $sql = "SELECT id FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }
        return true;
    }

}