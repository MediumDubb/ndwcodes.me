<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\ORM\DataObject;

class Project extends DataObject
{
    private static $table_name = "Whittendav_Projects";
    private static string $singular_name = "Project";
    private static string $plural_name = "Projects";
    private static string $default_sort = "SortOrder";
}
