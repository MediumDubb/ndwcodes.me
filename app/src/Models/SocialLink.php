<?php

namespace SirNoah\Whittendav\Models;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\UrlField;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;

class SocialLink extends DataObject
{
    private static $table_name = "Whittendav_SocialLinks";
    private static string $singular_name = "Social Link";
    private static string $plural_name = "Social Link";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'SortOrder'         => 'Int',
        'Link'              => 'Varchar(500)',
        'FaClass'           => 'Varchar(50)'
    ];

    private static array $has_one = [
        'SiteConfig'        => SiteConfig::class
    ];

    private static array $summary_fields = [
        'getIcon'           => 'Outlet',
        'Link'              => 'Link'
    ];

    private static array $font_awesome_social_icons = [
        'fa-brands fa-bluesky'  =>  'brand bluesky',
        'fa-brands fa-facebook'   =>  'brand facebook',
        'fa-brands fa-facebook-f'   =>  'brand facebook-f',
        'fa-brands fa-linkedin'    =>  'brand linkedin',
        'fa-brands fa-youtube' =>  'brand youtube',
        'fa-brands fa-google' =>  'brand google',
        'fa-brands fa-instagram' =>  'brand instagram',
        'fa-brands fa-tiktok' =>  'brand tiktok',
        'fa-brands fa-vimeo' =>  'brand vimeo',
        'fa-brands fa-x-twitter' =>  'brand x-twitter',
        'fa-brands fa-pinterest-p' =>  'brand pinterest-p',
    ];

    public function getIcon()
    {
        return $this->FaClass ? LiteralField::create('FaClass-Fa-Icon', '<span style="font-size:24px;"><i class="' . $this->FaClass . '"></i></span>') : $this->FaClass;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SiteConfigID',
            'Link',
            'SortOrder',
            'FaClass',
        ]);

        $fields->addFieldsToTab('Root.Main',[
                UrlField::create('Link', 'Link:'),
                DropdownField::create('FaClass', 'FontAwesome Icons:', self::$font_awesome_social_icons),
            ]
        );

        return $fields;
    }
}
