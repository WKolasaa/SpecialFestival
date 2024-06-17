<?php

namespace App\Controllers;

use App\Models\SectionType;

class PageManagementController
{
    public function getSectionTypes()
    {
        $sectionTypes = [];
        if (enum_exists('App\Models\SectionType')) {
            $sectionTypes = SectionType::cases();
            $sectionTypes = array_map(function($case) {
                return $case->value;
            }, $sectionTypes);
        }

        echo json_encode($sectionTypes);
    }
}