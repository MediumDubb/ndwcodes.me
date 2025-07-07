<?php

namespace SirNoah\Whittendav\PageTypes;

use Page;
use SirNoah\Whittendav\PageTypes\Controllers\ComponentPageController;

class ComponentPage extends Page
{
    private static string $table_name = "ComponentPage";
    private static string $singular_name = "Component Page";
    private static string $plural_name = "Component Pages";
    private static string $description = "A buildable page with arrangeable custom panels";

    private static string $controller_class = ComponentPageController::class;

    public function getCMSFields(): \SilverStripe\Forms\FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Content', 'H1']);

        return $fields;
    }


    public function onBeforeWrite() {
        $this->Content = $this->collateSearchContent();

        parent::onBeforeWrite();
    }


    protected function collateSearchContent() {
        $content = $this->getOwner()->getElementsForSearch();
        // Clean up the content
        return preg_replace('/\s+/', ' ', $content);
    }

    public function forTemplate(): string
    {
        return $this->Title;
    }

}
