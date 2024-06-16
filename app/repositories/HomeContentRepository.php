<?php

namespace App\Repositories;

use App\Models\HistoryEntryTypeEnum;
use App\Models\HomeCMSEntry;
use PDO;
use PDOException;

// importing classes and exceptions

class HomeContentRepository extends Repository
{

    public function getAll()
    {
        $sql = "SELECT id, content_name, content_type, content FROM home_contents";
        $statement = $this->connection->prepare($sql);
        $entries = [];

        try {
            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $content_type = $row["content_type"] == "TEXT" ? HistoryEntryTypeEnum::Text : HistoryEntryTypeEnum::Image;
                $entries[] = new HomeCMSEntry(
                    $row["id"],
                    $row["content_name"],
                    $content_type,
                    $row["content"]);
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $entries;
    }

    public function getContent($content_name)
    {
        $sql = "SELECT content FROM home_contents WHERE content_name = :content_name";
        $statement = $this->connection->prepare($sql);

        try {
            $statement->bindParam(':content_name', $content_name, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row && !empty($row['content'])) {
                return $row["content"];
            } else {
                return "<null>";
            }

        } catch (PDOException $e) {
            echo "ERROR LOADING " . $content_name;
        }
    }

    public function addEntry($content_name, $content_type, $content)
    {
        $sql = "INSERT INTO home_contents (content_name, content_type, content) VALUES (:content_name, :content_type, :content);";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(":content_name", $content_name, PDO::PARAM_STR);

        $content_type = $content_type == HistoryEntryTypeEnum::Text ? "TEXT" : "IMAGE";
        $statement->bindParam(":content_type", $content_type, PDO::PARAM_STR);

        $statement->bindParam(":content", $content, PDO::PARAM_STR);

        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateEntry($id, $content)
    {
        $sql = "UPDATE home_contents SET content = :content WHERE id = :id;";

        $statement = $this->connection->prepare($sql);

        try {
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":content", $content, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteEntry($id)
    {
        $sql = "DELETE FROM home_contents WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        try {
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getEntryContent($id)
    {
        $sql = "SELECT content FROM home_contents WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row ? $row["content"] : null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

}