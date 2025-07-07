<?php

namespace SirNoah\Whittendav\Extensions\CustomSearch;

use SilverStripe\CMS\Search\ContentControllerSearchExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBField;

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
        $search = $request->getVar('Search');
        $tab = $request->getVar('tab');
        $basePageURL = $request->getURL(false) . "?Search={$search}";

        $pagesTabActive = false;
        $articlesTabActive = false;
        $newsReleasesTabActive = false;
        $peopleTabActive = false;
        $caseStudyTabActive = false;

        $pageResults = $form->getResults();
        $showPageResults = $pageResults->TotalItems() > 0;

        $articlesResults = $form->getArticlesResults();
        $showArticlesResults = $articlesResults->TotalItems() > 0;

        $newsResults = $form->getNewsResults();
        $showNewsResults = $newsResults->TotalItems() > 0;

        $caseStudyResults = $form->getCaseStudyResults();
        $showCaseStudyResults = $caseStudyResults->TotalItems() > 0;

        $peopleResults = $form->getPeopleResults();
        $showPeopleResults = $peopleResults->count() > 0;

        if (is_null($tab)) {
            if ($showPageResults) {
                $results = $pageResults;
                $tab = "pages";
            } else if ($showArticlesResults) {
                $results = $articlesResults;
                $tab = "articles";
            } else if ($showNewsResults) {
                $results = $newsResults;
                $tab = "news-releases";
            } else if ($showPeopleResults) {
                $results = $peopleResults;
                $tab = "people";
            } else if ($showCaseStudyResults) {
                $results = $caseStudyResults;
                $tab = "people";
            } else {
                $results = false;
            }
        } else if ($tab == "pages" && $showPageResults) {
            $results = $pageResults;
        } else if ($tab == "articles" && $showArticlesResults) {
            $results = $articlesResults;
        } else if ($tab == "news-releases" && $showNewsResults) {
            $results = $newsResults;
        } else if ($tab == "people" && $showPeopleResults) {
            $results = $peopleResults;
        } else if ($tab == "case-studies" && $showCaseStudyResults) {
            $results = $caseStudyResults;
        } else {
            $results = false;
        }

        switch ($tab) {
            case "pages":
                $pagesTabActive = true;
                break;
            case "articles":
                $articlesTabActive = true;
                break;
            case "news-releases":
                $newsReleasesTabActive = true;
                break;
            case "people":
                $peopleTabActive = true;
                break;
            case "case-studies":
                $caseStudyTabActive = true;
                break;
        }

        $data = [
            'PageResultsLink'           => $basePageURL."&tab=pages",
            'ArticlesLink'              => $basePageURL."&tab=articles",
            'NewsReleasesLink'          => $basePageURL."&tab=news-releases",
            'PeopleLink'                => $basePageURL."&tab=people",
            'CaseStudyLink'             => $basePageURL."&tab=case-studies",
            'PagesTabActive'            => $pagesTabActive,
            'ArticlesTabActive'         => $articlesTabActive,
            'NewsReleasesTabActive'     => $newsReleasesTabActive,
            'CaseStudyTabActive'        => $caseStudyTabActive,
            'PeopleTabActive'           => $peopleTabActive,
            'Results'                   => $results,
            'ShowPageResults'           => $showPageResults,
            'ShowArticlesResults'       => $showArticlesResults,
            'ShowNewsResults'           => $showNewsResults,
            'ShowPeopleResults'         => $showPeopleResults,
            'ShowCaseStudyResults'      => $showCaseStudyResults,
            'Query'                     => DBField::create_field('Text', $form->getSearchQuery()),
            'Title'                     => _t('SilverStripe\\CMS\\Search\\SearchForm.SearchResults', 'Search Results')
        ];
        return $this->owner->customise($data)->renderWith(['Page_results', 'Page']);
    }
}
