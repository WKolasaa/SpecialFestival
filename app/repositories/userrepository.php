<?php
namespace App\Repositories;
use App\Models\User;

use PDO;

class UserRepository extends Repository{

  public function getAll(){
    

    $sql= "SELECT id, userName, password, userRole, registrationDate,firstName,lastName,email,photo FROM user";
    $rows=$this->executeQuery($sql);

    if (!$rows) {
      echo "No users found.";
      return [];
    }
    
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
        $username = $user->getUsername();
        $password = $user->getPassword();
        $userRole = $user->getUserRole();
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userRole', $userRole);

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
          $registeredDate = $row['registrationDate'];
          $email = $row['email'];
          $firstName = $row['firstName'];
          $lastName = $row['lastName'];
          $photo = $row['photo'];


            $user = new User( $id, $username, $password, $userRole,$registeredDate, $firstName, $lastName,$email, $photo);

            $users[] = $user;
        }

        return $users;
    }
 protected function executeQuery($sql)
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
      }catch (\PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
  }

    public function loginByEmail($email, $password)
    {
        $sql = "SELECT id, userName, password, userRole,registrationDate,email,firstName,LastName,photo FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if (password_verify($password, $row['password'])) {
            $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'],$row['registrationDate'], $row['email'], $row['firstName'], $row['lastName'], $row['photo']);
           
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
        if (password_verify($password, $row['password'])) { //TODO: fix this thing here. its making the login not work properly
            $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'],$row['registrationDate'], $row['email'], $row['firstName'], $row['lastName'], $row['photo']);           
            return $user;
        }
        return new User($row['id'], $row['userName'], $row['password'], $row['userRole'],$row['registrationDate'], $row['email'], $row['firstName'], $row['lastName'], $row['photo']);
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
        $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'],$row['registrationDate'], $row['email'], $row['firstName'], $row['lastName'], $row['photo']);           
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

    public function updatePassword($new_password, $email){
        $sql = "UPDATE user SET password = :password WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':password', $new_password);
        $statement->bindParam(':email', $email);
        $statement->execute();
    }

}