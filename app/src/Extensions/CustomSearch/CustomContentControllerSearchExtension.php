<?php

namespace SirNoah\Whittendav\Extensions\CustomSearch;

use Psr\Log\LoggerInterface;
use SilverStripe\CMS\Search\ContentControllerSearchExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

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
        $search = $request->getVar('q');
        $basePageURL = $request->getURL(false) . "?q={$search}";

        $pageResults = $form->getResults();

        $showPageResults = $pageResults->TotalItems() > 0;

        if ($showPageResults)
            return $pageResults->
    }
}
