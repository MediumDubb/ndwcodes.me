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

        try {
            $pageResults = $form->getResults();
        } catch (\Apache_Solr_HttpTransportException|\Apache_Solr_InvalidArgumentException $e) {
            Injector::inst()->get(LoggerInterface::class)->error( CustomContentControllerSearchExtension::class . ' line 27: ' . $e->getMessage());
        }


        $pagesTabActive = false;
        $articlesTabActive = false;
        $newsReleasesTabActive = false;
        $peopleTabActive = false;
        $caseStudyTabActive = false;

        $pageResults = $form->getResults();
        $showPageResults = $pageResults->TotalItems() > 0;


    }
}
