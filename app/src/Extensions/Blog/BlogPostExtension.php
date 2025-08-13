<?php

namespace SirNoah\Whittendav\Extensions\Blog;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SirNoah\Whittendav\Models\ContentSection;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class BlogPostExtension extends Extension
{

    private static $has_many = [
        'ContentSections'   => ContentSection::class,
    ];

    private static $owns = [
        'ContentSections'
    ];

    private static $cascade_deletes = [
        'ContentSections'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Content',
        ]);

        $fields->addFieldToTab('Root.Main',
            GridField::create('ContentSections',
            'Content Sections',
            $this->getOwner()->ContentSections(),
                GridFieldConfig_RecordEditor::create(10)
                    ->addComponent(GridFieldSortableRows::create('SortOrder'))
            ),
            'CustomSummary'
        );
    }

    public function onBeforeWrite()
    {
        $dbString = '<p>';

        if ($this->getOwner()->ContentSections()) {
            foreach($this->getOwner()->ContentSections() as $contentSection) {
                !empty($contentSection->CopyBlock) ? $dbString .= strip_tags($contentSection->CopyBlock) . ' ' : $dbString .= '';
            }
        }

        $this->getOwner()->Content = $dbString . "</p>";
    }
}
