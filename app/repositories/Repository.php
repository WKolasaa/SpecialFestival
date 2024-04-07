<?php

namespace App\Repositories;

use PDO;
use PDOException;

class Repository
{

    protected $connection;

    function __construct()
    {

        require __DIR__ . '/../config/dbconfig.php';

        try {
            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //  echo "connection successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();

        }
    }

    protected function executeQuery($sql): false|array
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
        }
    }
}