<?php

namespace SirNoah\Whittendav\Extensions\CustomSearch;

use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DB;

class CustomSearchForm extends SearchForm
{
    /**
    * Classes to search
    *
    * @var array
    */
    protected array $customClassesToSearch = [
        SiteTree::class
    ];

    // remove some page types from main results, since they'll be
    // displayed in other tabs
    protected array $excludedPageTypes = [
        RedirectorPage::class,
    ];

    /**
     * @skipUpgrade
     * @param RequestHandler|null $controller
     * @param string $name The name of the form (used in URL addressing)
     * @param FieldList|null $fields Optional, defaults to a single field named "Search". Search logic needs to be customized
     *  if fields are added to the form.
     * @param FieldList|null $actions Optional, defaults to a single field named "Go".
     */
    public function __construct(
        RequestHandler $controller = null,
                       $name = 'SearchForm',
        FieldList $fields = null,
        FieldList $actions = null
    ) {
        if (!$fields) {
            $fields = new FieldList(
                new TextField('Search', 'Search')
            );
        }

        if (!$actions) {
            $actions = new FieldList(
                FormAction::create("results", 'Go')
            );
        }

        parent::__construct($controller, $name, $fields, $actions);

        $this->setFormMethod('get');

        $this->disableSecurityToken();
    }

    /**
     * Return dataObjectSet of the results using current request to get info from form.
     * Wraps around {@link searchEngine()}.
     */
    public function getResults()
    {
        // Get request data from request handler
        $request = $this->getRequestHandler()->getRequest();

        $keywords = $request->requestVar('q');

        $andProcessor = function ($matches) {
            return ' +' . $matches[2] . ' +' . $matches[4] . ' ';
        };
        $notProcessor = function ($matches) {
            return ' -' . $matches[3];
        };

        $keywords = preg_replace_callback('/()("[^()"]+")( and )("[^"()]+")()/i', $andProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )([^() ]+)( and )([^ ()]+)( |$)/i', $andProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )(not )("[^"()]+")/i', $notProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )(not )([^() ]+)( |$)/i', $notProcessor, $keywords);

        $keywords = $this->addStarsToKeywords($keywords);

        $pageLength = $this->getPageLength();
        $start = $request->requestVar('start') ?: 0;

        $booleanSearch =
            strpos($keywords, '"') !== false ||
            strpos($keywords, '+') !== false ||
            strpos($keywords, '-') !== false ||
            strpos($keywords, '*') !== false;

        // remove some page types from main results, since they'll be
        // displayed in other tabs
        $extraFilter = "ClassName NOT IN ('" . implode("','", str_replace("\\","\\\\",$this->excludedPageTypes)) . "')";

        $results = DB::get_conn()->searchEngine($this->customClassesToSearch, $keywords, $start, $pageLength, "\"Relevance\" DESC", $extraFilter, $booleanSearch);

        // filter by permission
        if ($results) {
            foreach ($results as $result) {
                if (!$result->canView()) {
                    $results->remove($result);
                }
            }
        }

        if ($this->getRequest()->isAjax())
            return $this->customise($results)->renderWith(['Page_results.ss', 'Page']);
        else
            return $results;
    }
}
