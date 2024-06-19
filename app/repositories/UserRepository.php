<?php

namespace App\Repositories;

use App\Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository
{

    public function getAll()
    {


        $sql = "SELECT id, userName, password, userRole, registrationDate,firstName,lastName,email,photo,phoneNumber FROM user";
        $rows = $this->executeQuery($sql);

        if (!$rows) {
            echo "No users found.";
            return [];
        }

        return $this->mapToUserObjects($rows);
    }

    protected function executeQuery($sql): array
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
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
            $phoneNumber = $row['phoneNumber'];


            $user = new User($id, $username, $password, $userRole, $registeredDate, $firstName, $lastName, $email, $photo, $phoneNumber);

            $users[] = $user;
        }

        return $users;
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
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error updating user information: ' . $e->getMessage());
        }
    }

    public function deleteUserByAdmin(User $user)
    {
        try {
            // Use a prepared statement to delete the user by username
            $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
            $userId = $user->getId();
            $stmt->bindParam(':id', $userId, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Return true if deletion is successful
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error deleting user: ' . $e->getMessage());

        }

    }

    public function createUserByAdmin(User $user)
    {
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
        } catch (PDOException $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new PDOException('Error creating user: ' . $e->getMessage());
        }
    }

    public function addUser($userName, $firstName, $lastName, $email, $password, $photo, $phoneNumber)
    {
        $sql = "INSERT INTO user (userName, firstName, lastName, email, password, photo,phoneNumber) VALUES (:userName, :firstName, :lastName, :email, :password, :photo,:phoneNumber)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':userName', $userName);
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':photo', $photo);
        $statement->bindParam(':phoneNumber', $phoneNumber);
        try {
            $statement->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function loginByEmail($email, $password): ?User
    {
        $sql = "SELECT id, userName, password, userRole,registrationDate,email,firstName,LastName,photo,phoneNumber FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if (password_verify($password, $row['password'])) {
            $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'], $row['registrationDate'], $row['firstName'], $row['lastName'], $row['email'], $row['photo'], $row['phoneNumber']);
            return $user;
        }
        return null;
    }

    public function loginByUserName($userName, $password): ?User
    {
        $sql = "SELECT id, userName, password, userRole, registrationDate, email, firstName, lastName, photo,phoneNumber FROM user WHERE userName = :userName";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':userName', $userName);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if (password_verify($password, $row['password'])) {
            return new User($row['id'], $row['userName'], $row['password'], $row['userRole'], $row['registrationDate'], $row['firstName'], $row['lastName'], $row['email'], $row['photo'], $row['phoneNumber']);
        }
        return null;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, userName, password, userRole, registrationDate, email, firstName, lastName, photo,phoneNumber FROM user WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'], $row['registrationDate'], $row['email'], $row['firstName'], $row['lastName'], $row['photo'], $row['phoneNumber']);
        return $user;
    }

    public function getUserById($userId)
    {
        $sql = "SELECT id, userName, password, userRole, registrationDate, email, firstName, lastName, photo,phoneNumber FROM user WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $userId);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $user = new User($row['id'], $row['userName'], $row['password'], $row['userRole'], $row['registrationDate'], $row['firstName'], $row['lastName'], $row['email'], $row['photo'], $row['phoneNumber']);
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

    public function updateUser(User $user)
    {

        // var_dump($user);
        try {
            $sql = "UPDATE user SET userName = :userName, firstName = :firstName, lastName = :lastName, email = :email, password = :password, photo = :photo, userRole=:userRole, phoneNumber=:phoneNumber WHERE id = :id";
            $params = [
                ':userName' => $user->getUsername(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':photo' => $user->getPhoto(),
                ':id' => $user->getId(),
                ':userRole' => $user->getUserRole(),
                ':phoneNumber' => $user->getPhoneNumber()
            ];
            $statement = $this->connection->prepare($sql);

            $statement->execute($params);
            $rowCount = $statement->rowCount();


            if ($rowCount > 0) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new PDOException('Error updating user information: ' . $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        try {
            $sql = "DELETE FROM user WHERE id = :id";
            $params = [':id' => $userId];
            $statement = $this->connection->prepare($sql);
            $statement->execute($params);
            $rowCount = $statement->rowCount();

            if ($rowCount > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new PDOException('Error deleting user: ' . $e->getMessage());
        }
    }

    public function updatePassword($new_password, $email)
    {
        $sql = "UPDATE user SET password = :password WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':password', $new_password);
        $statement->bindParam(':email', $email);
        $statement->execute();
    }

}