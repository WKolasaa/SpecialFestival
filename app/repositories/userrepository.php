<?php
namespace App\Repositories;
use App\Models\User;

use PDO;

class UserRepository extends Repository{

  public function getAll(){

    $sql= "SELECT id, userName, password, userRole, registrationDate FROM user";
    $rows=$this->executeQuery($sql);

    if (!$rows) {
      echo "No users found.";
      return [];
    }
    
  //  echo "query works successfully";
    return $this->mapToUserObjects($rows);
  }

  public function updateUserByAdmin(User $user)
{
    try {
        // Prepare the SQL statement
        $stmt = $this->connection->prepare("
            UPDATE user
            SET 
                username = :username, 
                userRole = :userRole
            WHERE id = :id
        ");

        // Bind parameters
        $stmt->bindParam(':id', $user->getId());
        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':userRole', $user->getUserRole());

        // Execute the statement
        $stmt->execute();

        // Check if any rows were affected
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            // User information updated successfully
            return true;
        } else {
            // No rows were affected, possibly because the user ID was not found
            return false;
        }
    } catch (\PDOException $e) {
        // Handle the exception (log, show an error message, etc.)
        throw new \PDOException('Error updating user information: ' . $e->getMessage());
    }
}

public function deleteUserByAdmin(User $user){
  // var_dump($user);
      try {
        // Use a prepared statement to delete the user by username
        $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
        $userId=$user->getId();
        $stmt->bindParam(':id', $userId, PDO::PARAM_STR);
        $stmt->execute();

        return true; // Return true if deletion is successful
    } catch (\PDOException $e) {
        // Handle the exception (log, show an error message, etc.)
        throw new \PDOException('Error deleting user: ' . $e->getMessage());

  }

}

public function createUserByAdmin(User $user){
    try {
      // Prepare the SQL statement
      $stmt = $this->connection->prepare("
          INSERT INTO user (username, password, userRole)
          VALUES (:username, :password, :userRole)
      ");

      // Bind parameters
      $stmt->bindParam(':username', $user->getUsername());
      $stmt->bindParam(':password', $user->getPassword());
      $stmt->bindParam(':userRole', $user->getUserRole());

      // Execute the statement
      $stmt->execute();

      // Check if any rows were affected
      $rowCount = $stmt->rowCount();

      if ($rowCount > 0) {
          // User information updated successfully
          return true;
      } else {
          // No rows were affected, possibly because the user ID was not found
          return false;
      }
  } catch (\PDOException $e) {
      // Handle the exception (log, show an error message, etc.)
      throw new \PDOException('Error creating user: ' . $e->getMessage());
  }
}

  

  private function mapToUserObjects($rows)
    {
        $users = [];

        foreach ($rows as $row) {
          $id = $row['id'];
          $username = $row['userName'];
          $password = $row['password'];
          $userRole = $row['userRole'];
          $registrationDate = $row['registrationDate'];

            $user = new User($id, $username, $password, $userRole, $registrationDate);

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