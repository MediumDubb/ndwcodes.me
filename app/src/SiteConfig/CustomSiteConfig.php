<?php

namespace SirNoah\Whittendav\SiteConfig;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\UrlField;
use SirNoah\Whittendav\Models\SocialLink;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class CustomSiteConfig extends Extension
{
    private static $table_name = 'Whittendav_CustomSiteConfig';

    private static $db = [
        'ContactInfo'       => 'Varchar(15)',
        'Copyright'         => 'HTMLText',
        'GoogleTagManagerID'=> 'Varchar(50)',
    ];

    private static $has_one = [
        'Logo'              => Image::class,
        'Favicon'           => Image::class,
    ];

    private static array $has_many = [
        'SocialLinks'       => SocialLink::class
    ];

    private static $owns = [
        'Logo',
        'Favicon',
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $accessTab = $fields->findTab('Root.Access');
        TinyMCEConfig::get('cms')->insertButtonsAfter('underline', 'superscript');

        $fields->removeByName([
            'Main',
            'Title',
            'Access',
            'SocialLinks',
        ]);

        $fields->findOrMakeTab('Root.Main', 'SportsGrass Global Settings');
        $fields->addFieldsToTab('Root.Main', [
            TabSet::create('SportsGrassSiteSettings', 'SportsGrass Settings',
                Tab::create('Settings', 'Main Settings',
                    TextField::create('Title', 'Site Title'),
                    TextField::create('Tagline', 'Site Tagline/Slogan'),
                    UploadField::create('Favicon', 'Favicon')->setFolderName('favicon')
                        ->setDescription('Use a 64x64 png image named "favicon.png" for maximum compatibility.'),
                    UploadField::create('Logo', 'Logo White')
                        ->setFolderName("Uploads/Logos")
                        ->setDescription('Brand logo'),
                ),
                Tab::create('GoogleTracking', 'Google/Tracking',
                    TextField::create('GoogleTagManagerID', 'Google Tag Manager ID'),
                ),
                Tab::create('ViolatorsPopUps', 'Notices/Pop-ups',

                ),

                Tab::create('Footer', 'Footer',
                    TabSet::create('FooterTabsTabSet',
                        Tab::create('LocationContactTab', 'Contact/Location',
                            TextField::create('Phone', 'Contact Number:')->setDescription('Formatted phone number for top nav.'),
                            TextField::create('Address', 'Address:'),
                            UrlField::create('AddressMapLink', 'Map Link:'),
                        ),
                        Tab::create('SocialTab', 'Social Media',
                            GridField::create('SocialLinks',
                            'Social Links:',
                            $this->getOwner()->SocialLinks(),
                            GridFieldConfig_RecordEditor::create()
                                    ->addComponent(GridFieldSortableRows::create('SortOrder'))
                            ),
                        ),
                        Tab::create('CopyrightTab', 'Copyright',
                            TextField::create('MadeInTxt', 'Made in Text:'),
                            UploadField::create('MadeInImg', 'Made in Image:')
                                ->setFolderName('Uploads/Site-Settings'),
                            HTMLEditorField::create('Copyright', 'Copyright:')
                        ),
                    )
                ),
                $accessTab
            )
        ]);


        return $fields;
    }
}
