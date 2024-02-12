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



}