<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class ImageBlockRotator extends DataObject
{
    private static string $table_name = "Whittendav_ImageBlockRotator";
    private static string $singular_name = "Image Block";
    private static string $plural_name = "Image Blocks";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'HighlightText' => 'Varchar(500)'
    ];

    private static array $has_many = [
        'Images'        => Image::class,
    ];

    private static array $owns = [
        'Images',
    ];
}
