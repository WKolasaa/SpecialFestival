<?php

namespace App\Models;

enum SectionType: string
{
    case Header = 'header';
    case Section = 'section';
    case ImageSection = 'imageSection';
}