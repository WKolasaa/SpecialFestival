<?php

namespace App\Repositories;

use PDOException;

class tokenrepository extends Repository
{
    public function updateResetToken($userId, $token) {
        $sql = "UPDATE users SET reset_token = :token WHERE id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':token', $token, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        try{
            $statement->execute();
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
}