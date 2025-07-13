<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\ORM\DataObject;

class TextBlock extends DataObject
{
    private static string $table_name = "Whittendav_TextBlock";
    private static string $singular_name = "Text Block";
    private static string $plural_name = "Text Blocks";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'CopyBlock' => 'HTMLText',
        'CodeBlock' => 'HTMLText',
    ];
}
