<?php

namespace App\Services;

use App\Repositories\PageManagementRepository;

class PageManagementService
{
    private PageManagementRepository $pageManagementRepository;

    public function __construct()
    {
        $this->pageManagementRepository = new PageManagementRepository();
    }

    public function getAllPages(): false|array|null
    {
        return $this->pageManagementRepository->getAllPages();
    }

    public function getSectionsByPage($pageId): false|array|null
    {
        return $this->pageManagementRepository->getSectionsByPage($pageId);
    }

    public function getPageTitle($pageId)
    {
        return $this->pageManagementRepository->getPageTitle($pageId);
    }

    public function getSectionContent($sectionId): ?array
    {
        return $this->pageManagementRepository->getSectionContent($sectionId);
    }

    public function getParagraphsBySection($sectionId): array
    {
        return $this->pageManagementRepository->getParagraphsBySection($sectionId);
    }

    public function updateParagraph($paragraph, $paragraphId): void
    {
        $this->pageManagementRepository->updateParagraph($paragraph, $paragraphId);
    }

    public function addParagraph($paragraph, $sectionId): void
    {
        $this->pageManagementRepository->addParagraph($paragraph, $sectionId);
    }

    public function updateSection($sectionId, $heading, $subTitle): void
    {
        $this->pageManagementRepository->updateSection($sectionId, $heading, $subTitle);
    }

    public function updateImage($imageId, $imagePath): void
    {
        $this->pageManagementRepository->updateImage($imageId, $imagePath);
    }

    public function addImage($sectionId, $imageName, $imagePath): void
    {
        $this->pageManagementRepository->addImage($sectionId, $imageName, $imagePath);
    }

    public function getImagesBySection($sectionId): array
    {
        return $this->pageManagementRepository->getImagesBySection($sectionId);
    }

    public function getImageById($imageId): false|array|null
    {
        return $this->pageManagementRepository->getImageById($imageId);
    }

    public function addPage($pageTitle, $pageLink): false|string|null
    {
        return $this->pageManagementRepository->addPage($pageTitle, $pageLink);
    }

    public function addSection($pageId, $sectionType): false|string|null
    {
        return $this->pageManagementRepository->addSection($pageId, $sectionType);
    }

    public function deleteSection($sectionId): bool
    {
        return $this->pageManagementRepository->deleteSection($sectionId);
    }

    public function deletePage($pageId): bool
    {
        return $this->pageManagementRepository->deletePage($pageId);
    }

    public function deleteParagraphsBySection($sectionId): void
    {
        $this->pageManagementRepository->deleteParagraphsBySection($sectionId);
    }
}