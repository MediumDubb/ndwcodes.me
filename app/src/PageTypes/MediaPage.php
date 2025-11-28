<?php

namespace SirNoah\Whittendav\PageTypes;

use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SirNoah\Whittendav\Models\BasePost;
use SirNoah\Whittendav\Models\BasePostCategory;
use SirNoah\Whittendav\PageTypes\Controllers\MediaPageController;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class MediaPage extends Page
{
    private static string $table_name = 'Page_MediaPage';
    private static string $singular_name = 'Media Page';
    private static string $plural_name = 'Media Pages';
    private static string $class_description = 'A page that can create and display posts (News, Events, Blog, etc...)';
    private static string $controller_name = MediaPageController::class;

    private static array $has_many = [
        'Posts'         => BasePost::class
    ];

    private static array $many_many = [
        'Categories'    => BasePostCategory::class
    ];

    private static array $many_many_extraFields = [
        'Categories'    => [
            'CategoriesSortOrder' => 'Int',
        ]
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
           'Categories',
        ]);

        $fields->addFieldToTab('Root.Categories',
            GridField::create('Categories',
                'Categories',
                $this->getSortedCategories(),
                GridFieldConfig_RecordEditor::create()
                    ->addComponent(new GridFieldSortableRows('CategoriesSortOrder'))
            ),
        );

        return $fields;
    }

    public function getSortedCategories() {
        return $this->getManyManyComponents('Categories')->sort('CategoriesSortOrder');
    }
}
