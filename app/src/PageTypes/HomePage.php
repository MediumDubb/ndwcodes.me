<?php

namespace SirNoah\Whittendav\PageTypes;

use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;

class HomePage extends Page
{
    private static string $table_name = "Page_HomePage";
    private static string $singular_name = "Home Page";
    private static string $plural_name = "Home Pages";
    private static string $description = "A page template for the front of noahdw.me";

    private static array $db = [
        'First'         => 'Varchar(50)',
        'Middle'        => 'Varchar(50)',
        'Last'          => 'Varchar(50)',
        'Sub'           => 'Varchar(255)',
        'FrontEndCopy'  => 'HTMLText',
    ];

    private static array $has_one = [
        'Image'         => Image::class,
    ];

    private static array $owns = [
        'Image',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $folder = $this->getBaseFolderName() . '/' . $this->i18n_singular_name();

        $fields->removeByName([
            'H1',
            'First',
            'Middle',
            'Last',
            'Image',
            'Content',
        ]);

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('First', 'First:'),
            TextField::create('Middle', 'Middle:'),
            TextField::create('Last', 'Last:'),
            TextField::create('Sub', 'Sub Heading:'),
            HTMLEditorField::create('FrontEndCopy', 'Front End Copy:')
                ->addExtraClass('stacked'),
            UploadField::create('Image')
                ->setFolderName($folder)
        ], 'Metadata');

        return $fields;
    }

    public function onBeforeWrite()
    {
        $dbContentSting = '';

        foreach (self::$db as $fieldName => $fieldType) {
            !empty($this->$fieldName) ? $dbContentSting .= ' ' . strip_tags($this->$fieldName) : $dbContentSting .= '';
        }

        $this->Content = $dbContentSting;

        parent::onBeforeWrite();
    }
}
