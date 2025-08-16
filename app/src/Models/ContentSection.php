<?php

namespace SirNoah\Whittendav\Models;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class ContentSection extends DataObject
{
    private static string $table_name = "Whittendav_ContentSection";
    private static string $singular_name = "Content Section";
    private static string $plural_name = "Content Sections";
    private static string $default_sort = "SortOrder";

    private static array $db = [
        'SortOrder'         => 'Int',
        'SectionTitle'      => 'Varchar(150)',
        'CopyBlock'         => 'HTMLText',
    ];

    private static array $has_one = [
        'BlogPost'          =>  BlogPost::class,
    ];

    private static array $has_many = [
        'Images'            => Image::class
    ];

    private static array $summary_fields = [
        'SectionTitle'      => 'Section Title'
    ];

    private static array $owns = [
        'Images',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SortOrder',
            'BlogPostID',
            'SectionTitle',
            'CopyBlock',
            'Images',
        ]);

        $fields->findOrMakeTab('Root.Main', 'Content Section');

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('SectionTitle', 'Section Title:'),
            TabSet::create('MainTabSet', 'Main Tab Set',
                Tab::create('Copy', 'Copy Block',
                    HTMLEditorField::create('CopyBlock', 'Copy Block')
                ),
                Tab::create('Images', 'Images',
                    SortableUploadField::create('Images')
                        ->setFolderName('Content-Images')
                ),
            )]
        );

        return $fields;
    }
}
