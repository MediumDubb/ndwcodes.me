<?php

namespace SirNoah\Whittendav\Models\Resume;

use SilverStripe\ORM\DataObject;
use SirNoah\Whittendav\PageTypes\ResumePage;

class Edu extends DataObject
{
    private static string $table_name = "Whittendav_Edu";
    private static string $singular_name = "Education";
    private static string $plural_name = "Education";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'SortOrder'     => 'Int',
        'Title'         => 'Varchar(255)',
        'YearStart'     => 'Date',
        'YearEnd'       => 'Date',
        'Institution'   => 'Varchar(255)',
        'List'          => 'HTMLText',
    ];

    private static array $has_one = [
        'ResumePage'    => ResumePage::class,
    ];

    private static array $owns = [
        'ResumePage',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SortOrder',
            'ResumePageID',
        ]);

        return $fields;
    }
}
