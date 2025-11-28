<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\ORM\DataObject;

class BasePostCategory extends DataObject
{
    private static string $table_name = 'Whittendav_BasePostCategory';
    private static string $singular_name = 'Post Category';
    private static string $plural_name = 'Post Categories';
    private static string $class_description = 'A simple post category for filtering';

    private static array $db = [
        'Title' => 'Varchar(255)',
    ];
}
