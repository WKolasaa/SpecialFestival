<?php

namespace App\Repositories;

use PDO;
use PDOException;

class PageManagementRepository extends Repository
{
    public function getAllPages(): false|array|null
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Pages");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error retrieving pages: " . $e->getMessage());
            return null;
        }
    }

    public function getSectionsByPage($pageId): false|array|null
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Sections WHERE pageId = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error retrieving sections of page: " . $e->getMessage());
            return null;
        }
    }

    public function getPageTitle($pageId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT pageTitle FROM Pages WHERE pageId = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['pageTitle'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Error retrieving page title: " . $e->getMessage());
            return null;
        }
    }

    public function getSectionContent($sectionId): ?array
    {
        try {
            $sectionStmt = $this->connection->prepare("SELECT * FROM Sections WHERE sectionId = :sectionId");
            $sectionStmt->bindParam(':sectionId', $sectionId);
            $sectionStmt->execute();
            $section = $sectionStmt->fetch(PDO::FETCH_ASSOC);

            $paragraphs = $this->getParagraphsBySection($sectionId);

            $images = $this->getImagesBySection($sectionId);

            return [
                'section' => $section,
                'paragraphs' => $paragraphs,
                'images' => $images
            ];
        } catch (PDOException $e) {
            error_log("Error retrieving section content: " . $e->getMessage());
            return null;
        }

    }

    public function getParagraphsBySection($sectionId): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("Error retrieving paragraphs: " . $e->getMessage());
            return [];
        }
    }

    public function getImagesBySection($sectionId): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("Error retrieving images: " . $e->getMessage());
            return [];
        }
    }

    public function updateParagraph($paragraph, $paragraphId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Paragraph SET text = :text WHERE paragraphId = :paragraphId");
            $stmt->bindParam(':text', $paragraph);
            $stmt->bindParam(':paragraphId', $paragraphId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating paragraph: " . $e->getMessage());
            return null;
        }
    }

    public function addParagraph($paragraph, $sectionId)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Paragraph (sectionId, text) VALUES (:sectionId, :text)");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->bindParam(':text', $paragraph);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding paragraph: " . $e->getMessage());
            return null;
        }
    }

    public function updateImage($imageId, $imagePath)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Images SET imagePath = :imagePath WHERE imageId = :imageId");
            $stmt->bindParam(':imagePath', $imagePath);
            $stmt->bindParam(':imageId', $imageId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating image: " . $e->getMessage());
            return null;
        }
    }

    public function addImage($sectionId, $imageName, $imagePath)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Images (sectionId, imageName, imagePath) VALUES (:sectionId, :imageName, :imagePath)");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->bindParam(':imageName', $imageName);
            $stmt->bindParam(':imagePath', $imagePath);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error radding images: " . $e->getMessage());
            return null;
        }
    }

    public function getImageById($imageId): false|array|null
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Images WHERE imageId = :imageId");
            $stmt->bindParam(':imageId', $imageId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error retrieving images: " . $e->getMessage());
            return null;
        }
    }

    public function addPage($pageTitle): false|string|null
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Pages (pageTitle) VALUES (:pageTitle)");
            $stmt->bindParam(':pageTitle', $pageTitle);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding page: " . $e->getMessage());
            return null;
        }
    }

    public function addSection($pageId, $sectionType): false|string|null
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Sections (pageId, type) VALUES (:pageId, :sectionType)");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->bindParam(':sectionType', $sectionType);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding section: " . $e->getMessage());
            return null;
        }
    }

    public function deleteSection($sectionId): bool
    {
        try {
            $this->deleteParagraphsBySection($sectionId);
            $this->deleteImagesBySection($sectionId);
            $this->deleteSectionById($sectionId);
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting section: " . $e->getMessage());
            return false;
        }
    }

    public function deleteParagraphsBySection($sectionId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Paragraph WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting paragraph: " . $e->getMessage());
            return null;
        }
    }

    private function deleteImagesBySection($sectionId): void
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Images WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting images: " . $e->getMessage());
            return;
        }
    }

    private function deleteSectionById($sectionId): void
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Sections WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting section: " . $e->getMessage());
            return;
        }
    }

    public function deletePage($pageId): bool
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Pages WHERE pageId = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting page: " . $e->getMessage());
            return false;
        }
    }
}