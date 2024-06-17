<?php

namespace App\Models;

enum SectionType: string
{
    case Header = 'header';
    case Subsection = 'subsection';
    case Introduction = 'introduction';
    case ImageSection = 'imageSection';
}