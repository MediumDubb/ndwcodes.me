<?php

namespace SirNoah\Whittendav\Models\Resume;

use SilverStripe\ORM\DataObject;

class Exp extends DataObject
{
    private static string $table_name = "Whittendav_Exp";
    private static string $singular_name = "Work Experience";
    private static string $plural_name = "Work Experience";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'Title'         => 'Varchar(255)', // Company Name
        'YearStart'     => 'Date',
        'YearEnd'       => 'Date',
        'Current'       => 'Boolean',
        'PositionTitle' => 'Varchar(255)',
        'List'          => 'HTMLText',
    ];
}
