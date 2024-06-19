<?php

namespace App\Controllers;

use App\Services\PageManagementService;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class PageManagementController
{
    private PageManagementService $pageManagementService;

    public function __construct()
    {
        $this->pageManagementService = new PageManagementService();
    }

    public function index(): void
    {
        try {
            $pages = $this->pageManagementService->getAllPages();
            require __DIR__ . '/../views/CustomPages/listPage.php';
        } catch (Exception $e) {
            $this->handleException($e, "Error retrieving pages");
        }
    }

    #[NoReturn] private function handleException(Exception $e, string $logMessage = "Error"): void
    {
        error_log("$logMessage: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }

    public function sections(): void
    {
        try {
            $pageId = $this->sanitizeInput($_GET['pageId'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            $pageTitle = $this->pageManagementService->getPageTitle($pageId);
            $sections = $this->pageManagementService->getSectionsByPage($pageId);
            require __DIR__ . '/../views/CustomPages/listSections.php';
        } catch (Exception $e) {
            $this->handleException($e, "Error retrieving sections");
        }
    }

    private function sanitizeInput(mixed $input, int $filterType): mixed
    {
        return filter_var($input, $filterType);
    }

    public function addPage(): void
    {
        require __DIR__ . '/../views/CustomPages/addPage.php';
    }

    public function showPage(): void
    {
        try {
            session_start();
            $pageId = $this->sanitizeInput($_GET['pageId'] ?? null, FILTER_SANITIZE_NUMBER_INT);

            if ($pageId) {
                $sections = $this->pageManagementService->getSectionsByPage($pageId);
                foreach ($sections as $key => $section) {
                    $sections[$key]['images'] = $this->pageManagementService->getImagesBySection((int)$section['sectionId']);
                    $sections[$key]['paragraphs'] = $this->pageManagementService->getParagraphsBySection((int)$section['sectionId']);
                }
                require __DIR__ . '/../views/CustomPages/templatePage.php';
            }
        } catch (Exception $e) {
            $this->handleException($e, "Error showing the page");
        }
    }
}
