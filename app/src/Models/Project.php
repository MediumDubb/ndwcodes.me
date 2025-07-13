<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\ORM\DataObject;

class Project extends DataObject
{
    private static string $table_name = "Whittendav_Projects";
    private static string $singular_name = "Project";
    private static string $plural_name = "Projects";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)',
    ];
}
