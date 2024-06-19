<?php

namespace App\Controllers;

use App\Models\SectionType;
use App\Services\PageManagementService;
use DOMDocument;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class PageManagementController
{
    private PageManagementService $pageManagementService;

    public function __construct()
    {
        $this->pageManagementService = new PageManagementService();
    }

    public function getSectionTypes(): void
    {
        $sectionTypes = [];
        if (enum_exists('App\Models\SectionType')) {
            $sectionTypes = SectionType::cases();
            $sectionTypes = array_map(function ($case) {
                return $case->value;
            }, $sectionTypes);
        }

        echo json_encode($sectionTypes);
    }

    public function getSectionContent(): void
    {
        try {
            if (isset($_GET['sectionId'])) {
                $sectionId = $this->sanitizeInput($_GET['sectionId'], FILTER_SANITIZE_NUMBER_INT);
                $sectionContent = $this->pageManagementService->getSectionContent($sectionId);
                echo json_encode($sectionContent);
            } else {
                echo json_encode(['error' => 'Section ID is not provided']);
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error retrieving section content");
        }
    }

    private function sanitizeInput(mixed $input, int $filterType): mixed
    {
        return filter_var($input, $filterType);
    }

    #[NoReturn] private function handleException(Exception $e, string $logMessage = "Error"): void
    {
        error_log("$logMessage: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }

    public function savePage(): void
    {
        try {
            $this->validateInput($_POST, ['pageTitle']);
            $pageTitle = $this->sanitizeInput($_POST['pageTitle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pageLink = '/pageManagement/showPage';
            $pageId = $this->pageManagementService->addPage($pageTitle, $pageLink);

            if (isset($_POST['sections']) && is_array($_POST['sections'])) {
                foreach ($_POST['sections'] as $index => $section) {
                    $sectionType = $this->sanitizeInput($section['sectionType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $content = $section['content'];

                    $sectionId = $this->pageManagementService->addSection($pageId, $sectionType);

                    $paragraphs = $this->extractParagraphs($content);
                    foreach ($paragraphs as $paragraph) {
                        $this->pageManagementService->addParagraph($paragraph, $sectionId);
                    }

                    if (isset($_FILES['sections']['tmp_name'][$index]['images'])) {
                        $this->uploadImagesForSection($_FILES['sections']['name'][$index]['images'], $_FILES['sections']['tmp_name'][$index]['images'], $sectionId);
                    }
                }
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error saving the page");
        }
    }

    /**
     * @throws Exception
     */
    private function validateInput(array $input, array $requiredKeys): void
    {
        foreach ($requiredKeys as $key) {
            if (!isset($input[$key])) {
                throw new Exception("Missing required input: $key");
            }
        }
    }

    /**
     * @throws Exception
     */
    private function extractParagraphs(string $content): array
    {
        if (empty($content)) {
            return [];
        }

        try {
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            $paragraphs = [];

            foreach ($dom->getElementsByTagName('p') as $paragraph) {
                $paragraphContent = $dom->saveHTML($paragraph);
                if (trim(strip_tags($paragraphContent)) !== '') {
                    $paragraphs[] = $paragraphContent;
                }
            }

            return $paragraphs;
        } catch (Exception $e) {
            throw new Exception("Error extracting paragraphs: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function uploadImagesForSection(array $imageNames, array $imageTmpNames, int $sectionId): void
    {
        try {
            foreach ($imageNames as $key => $imageName) {
                $imageTmpName = $imageTmpNames[$key];
                $this->uploadImage($imageTmpName, $imageName, $key, $sectionId);
            }
        } catch (Exception $e) {
            throw new Exception("Error uploading images: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function uploadImage(string $imageTmpName, string $imageName, int $imageId, int $sectionId): void
    {
        try {
            $existingImages = $this->pageManagementService->getImageById($imageId);
            if ($existingImages) {
                foreach ($existingImages as $existingImage) {
                    $imagePath = "/img/CustomPages/" . $sectionId . "/" . $existingImage['imageName'];
                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                    $imageId = $existingImage['imageId'];
                    move_uploaded_file($imageTmpName, $uploadPath);
                    $this->pageManagementService->updateImage($imageId, $imagePath);
                }
            } else {
                $imagePath = "/img/CustomPages/" . $sectionId . "/" . $imageName;
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                // Ensure the target directory exists
                $directory = dirname($uploadPath);
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }

                if (!move_uploaded_file($imageTmpName, $uploadPath)) {
                    throw new Exception("Failed to move uploaded file to $uploadPath");
                }

                $this->pageManagementService->addImage($sectionId, $imageName, $imagePath);
            }
        } catch (Exception $e) {
            throw new Exception("Error uploading image: " . $e->getMessage());
        }
    }

    public function updateContent(): void
    {
        try {
            $this->validateInput($_POST, ['sectionId', 'content']);

            $sectionId = $this->sanitizeInput($_POST['sectionId'], FILTER_SANITIZE_NUMBER_INT);
            $content = $_POST['content'];

            $paragraphs = $this->extractParagraphs($content);
            $this->updateParagraphs($paragraphs, $sectionId);

            if (isset($_FILES['images'])) {
                $this->uploadImages($_FILES['images'], $sectionId);
            }
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * @throws Exception
     */
    private function updateParagraphs(array $paragraphs, int $sectionId): void
    {
        try {
            $this->pageManagementService->deleteParagraphsBySection($sectionId);

            foreach ($paragraphs as $paragraph) {
                $this->pageManagementService->addParagraph($paragraph, $sectionId);
            }
        } catch (Exception $e) {
            throw new Exception("Error updating paragraphs: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function uploadImages(array $uploadedImages, int $sectionId): void
    {
        try {
            foreach ($uploadedImages['tmp_name'] as $key => $tmp_name) {
                $this->uploadImage($tmp_name, $uploadedImages['name'][$key], $key, $sectionId);
            }
        } catch (Exception $e) {
            throw new Exception("Error uploading images: " . $e->getMessage());
        }
    }

    public function saveSection(): void
    {
        try {
            $this->validateInput($_POST['section'] ?? [], ['pageId', 'sectionType']);

            $section = $_POST['section'];
            $pageId = $this->sanitizeInput($section['pageId'], FILTER_SANITIZE_NUMBER_INT);
            $sectionType = $this->sanitizeInput($section['sectionType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($section['content'])) {
                $content = $section['content'];

                $sectionId = $this->pageManagementService->addSection($pageId, $sectionType);

                $paragraphs = $this->extractParagraphs($content);
                foreach ($paragraphs as $paragraph) {
                    $this->pageManagementService->addParagraph($paragraph, $sectionId);
                }
            }

            if (isset($_FILES['section']['tmp_name']['images']) && is_array($_FILES['section']['tmp_name']['images'])) {
                $sectionId = $this->pageManagementService->addSection($pageId, $sectionType, "", "");
                $this->uploadImagesForSection($_FILES['section']['name']['images'], $_FILES['section']['tmp_name']['images'], $sectionId);
            } else {
                echo json_encode('No image uploaded.');
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error saving the section");
        }
    }

    public function deletePage(): void
    {
        try {
            $pageId = $this->sanitizeInput($_GET['pageId'] ?? null, FILTER_SANITIZE_NUMBER_INT);

            if ($pageId) {
                $sections = $this->pageManagementService->getSectionsByPage($pageId);
                foreach ($sections as $section) {
                    $this->pageManagementService->deleteSection((int)$section['sectionId']);
                }

                if ($this->pageManagementService->deletePage($pageId)) {
                    header("Location: /pageManagement");
                    exit();
                } else {
                    echo "Failed to delete page.";
                }
            } else {
                echo "Page ID is not provided";
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error deleting the page");
        }
    }

    public function deleteSection(): void
    {
        try {
            $sectionId = $this->sanitizeInput($_GET['sectionId'] ?? null, FILTER_SANITIZE_NUMBER_INT);

            if ($sectionId && $this->pageManagementService->deleteSection($sectionId)) {
                header("Location: /pageManagement/sections?pageId=" . $_GET['pageId']);
                exit();
            } else {
                echo "Section ID is not provided or failed to delete section.";
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error deleting the section");
        }
    }
}