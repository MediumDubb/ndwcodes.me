<?php

namespace SirNoah\Whittendav\PageTypes;

use Page;
use SilverStripe\Assets\Image;
use SirNoah\Whittendav\Models\Resume\Edu;
use SirNoah\Whittendav\Models\Resume\Exp;

class ResumePage extends Page
{
    private static string $table_name = "Page_ResumePage";
    private static string $singular_name = "Resume Page";
    private static string $plural_name = "Resume Pages";
    private static string $description = "A page template for personal resume";

    private static array $db = [
        'First'         => 'Varchar(50)',
        'Last'          => 'Varchar(50)',
        'Title'         => 'Varchar(50)',
        // profile section
        'ProfileTitle'  => 'Varchar(50)',
        'Description'   => 'Varchar(750)',
        // Exp section
        'ExpTitle'      => 'Varchar(50)',
        // Contact section
        // Plans to use a cloudflare turnstile to vet user and return contact info when deemed not bot traffic
        'ContactTitle'  => 'Varchar(50)',
        'Email'         => 'Varchar(50)',
        'LinkedIn'      => 'Varchar(150)',
        // Education section
        'EduTitle'      => 'Varchar(50)',
        // Skills section
        'SkillsTitle'   => 'Varchar(50)',
        'SkillList'     => 'HTMLText',
        // Language section
        'LanguageTitle' => 'Varchar(50)',
        'LangList'      => 'HTMLText',
        // Project section
        'ProjectTitle'  => 'Varchar(50)',
        'ProjectList'   => 'HTMLText',
    ];

    private static array $has_many = [
        'Education'     => Edu::class,
        'Experience'    => Exp::class,
    ];

    private static array $has_one = [
        'Bust'          => Image::class,
        'Resume'        => Image::class,
    ];

    private static array $owns = [
        'Bust',
        'Resume',
    ];
}
