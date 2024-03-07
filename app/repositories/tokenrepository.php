<?php

namespace App\Repositories;

use App\Models\token;
use PDO;
use PDOException;

class tokenrepository extends Repository
{
    public function getResetToken($user_email){
        try{
            $sql = "SELECT * FROM reset_tokens WHERE user_email = :user_email";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':user_email', $user_email);
            $statement->execute();
            $rows = $statement ->rowCount();

            if ($rows) {
                return true;
            }
            else{
                return false;
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function mapToToken($rows){
        $token = null;
        foreach ($rows as $row) {
            $token = new Token();
            $token->setTokenId($row['id']);
            $token->setUserEmail($row['user_email']);
            $token->setToken($row['token']);
            $token->setCreatedAt($row['created_at']);
            $token->setExpiresAt($row['expires_at']);
        }

        return $token;
    }

    public function storeOrUpdateToken($user_email, $tokenString){
        try{
            $existingToken = $this->getResetToken($user_email);

            $expiresAt = date('Y-m-d H:i:s', time() + 60 * 15);

            if ($existingToken) {
                $sql = "UPDATE reset_tokens SET token = :token, expires_at = :expiresAt WHERE user_email = :user_email";
            }
            else {
                $sql = "INSERT INTO reset_tokens (user_email, token, expires_at) VALUES (:user_email, :token, :expiresAt)";
            }

            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':user_email', $user_email);
            $statement->bindParam(':token', $tokenString);
            $statement->bindParam(':expiresAt', $expiresAt);

            $statement->execute();
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}