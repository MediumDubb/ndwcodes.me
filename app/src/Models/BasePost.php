<?php

namespace SirNoah\Whittendav\Models;

use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class BasePost extends DataObject
{
    private static string $table_name = 'Whittendav_Post';
    private static string $singular_name = 'Post';
    private static string $plural_name = 'Posts';
    private static string $description = 'A simple post model';

    private static array $db = [
        'Title'             => 'Varchar(255)',
        'SpecialPreview'    => 'HTMLText',
        'MetaDescription'   => 'Varchar(160)',
        'OriginalURLSegment'=> 'Varchar(300)',
        'URLSegment'        => 'Varchar(300)',
        'PublishedOn'       => 'Datetime',
        'PostDate'          => 'Date',
    ];

    private static array $has_one = [
        'ParentPage'        => Page::class,
        'FeaturedImage'     => Image::class,
    ];

    private static array $has_many = [
        'ContentSections'  => ContentSection::class,
    ];

    private static array $indexes = [
        'URLSegment'        => true,
    ];

    private static array $owns = [
        'FeaturedImage',
    ];

    private static array $extensions = [
        Versioned::class,
    ];

    private static $many_many = [
        'FilterTags'        => BasePostCategory::class,
    ];

    private static $many_many_extraFields = [
        'FilterTags' => [
            'FilterTagsSortOrder' => 'Int',
        ]
    ];

    private static array $non_live_permissions = [
        'ADMIN',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'FeaturedImage',
            'SpecialPreview',
            'ParentPageID',
            'URLSegment',
            'OriginalURLSegment',
            'ParentPageID',
            'PublishedOn',
            'PostDate',
            'FilterTags',
            'ContentSections',
        ]);

        $fields->findOrMakeTab('Root.Main')->setTitle($this->i18n_singular_name());
        $fields->addFieldsToTab('Root.Main', [
            UploadField::create('FeaturedImage', 'Featured Image')
                ->setFolderName('Uploads/BlogPosts')
        ], 'Title');

        if ($this->getParentPageCategories()->count()) {
            $filter = ListboxField::create('FilterTags', 'Filter Tags', $this->getParentPageCategories()->map())
                ->setDescription("To add more categories navigate back to the parent page of this post and click on the 'Categories' tab in top tabbed menu");
        } else {
            $filter = LiteralField::create('EmptyField', '');
        }

        $fields->addFieldsToTab('Root.Main', [
            $filter,
            DateField::create('PostDate', 'Post Date', date('m/d/Y')),
            HTMLEditorField::create('SpecialPreview', 'Special Preview - Extra Summary')
                ->setRows(3)
                ->setDescription('This field is for special info that will appear on the post page above the post summary. Keep it short and sweet.'),
        ], 'PostBody');

        $fields->addFieldsToTab('Root.Main', [
            GridField::create(
                'ContentSections',
                'Content Sections',
                $this->ContentSections(),
                GridFieldConfig_RecordEditor::create()
                    ->addComponent(new GridFieldSortableRows('SortOrder')
                )
            ),
            ReadonlyField::create('URLSegment', 'URL Segment for post')
        ]);

        return $fields;
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        if (!$this->Title)
            $result->addFieldError('Title', 'Title is required');

        return $result;
    }

    public function Link(): string
    {
        $parentPageRel = $this->ParentPage()->RelativeLink();
        return $parentPageRel ? $parentPageRel . '/post/' . $this->URLSegment : '';
    }

    public function getTheURLSegment(): string
    {
        $slug = $this->OriginalURLSegment;
        $match = self::get()->exclude('ID', $this->ID)->filter(['OriginalURLSegment' => $slug]);

        if ($match->count() > 0)
            $slug .= '--' . ($match->count() + 1);

        return $slug;
    }

    public function onBeforeWrite(): void
    {
        if (!$this->OriginalURLSegment)
            $this->OriginalURLSegment = $this->getBaseSlug();

        if (!$this->URLSegment)
            $this->URLSegment = $this->getTheURLSegment();

        parent::onBeforeWrite();
    }

    protected function getBaseSlug(): string
    {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($this->Title));
        $needle = '-';
        $escaped_needle = preg_quote($needle, '/');
        $pattern = "/(" . $escaped_needle . ")+/";
        return preg_replace($pattern, '$1', $slug);
    }

    private function getParentPageCategories()
    {
        return $this->ParentPage()->Categories();
    }
}
