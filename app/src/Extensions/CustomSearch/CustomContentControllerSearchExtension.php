<?php

namespace SirNoah\Whittendav\Extensions\CustomSearch;

use SilverStripe\CMS\Search\ContentControllerSearchExtension;
use SilverStripe\Control\HTTPRequest;

class CustomContentControllerSearchExtension extends ContentControllerSearchExtension
{
    /**
     * Process and render search results.
     *
     * @param array $data The raw request data submitted by user
     * @param CustomSearchForm $form The form instance that was submitted
     * @param HTTPRequest $request Request generated for this action
     */
    public function results($data, $form, $request)
    {
        $results = $form->getResults();
        return $results->getValue();
    }
}
