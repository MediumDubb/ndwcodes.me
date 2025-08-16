<?php

namespace SirNoah\Whittendav\Models\Resume;

use SilverStripe\ORM\DataObject;

class Edu extends DataObject
{
    private static string $table_name = "Whittendav_Edu";
    private static string $singular_name = "Education";
    private static string $plural_name = "Education";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'Title'         => 'Varchar(255)',
        'YearStart'     => 'Date',
        'YearEnd'       => 'Date',
        'Institution'   => 'Varchar(255)',
        'List'          => 'HTMLText',
    ];
}
