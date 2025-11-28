<?php

namespace SirNoah\Whittendav\PageTypes\Controllers;

use SirNoah\Whittendav\Models\BasePost;
use Page;
use PageController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Model\List\PaginatedList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;

class MediaPageController extends PageController
{
    private static array $allowed_actions = [
        'getThePost',
        'getPagePaginatedPosts',
        'bgWhite',
    ];

    private static array $url_handlers = [
        '/post//$Segment!' => 'getThePost',
    ];

    protected function init(): void
    {
        parent::init();
    }

    public function bgWhite()
    {
        return true;
    }

    public function getThePost(HTTPRequest $request): DBHTMLText
    {
        $parentPagePosts = SiteTree::get()->filter('URLSegment', $request->param('URLSegment'))->first()->Posts();
        $postSlug = $this->getRequest()->param('Segment');
        $thePost = $parentPagePosts->filter('URLSegment', $postSlug)->first();

        return $this->customise($thePost)->renderWith([BasePost::class . '_DetailPage', Page::class]);
    }

    public function getPagePaginatedPosts(): ?PaginatedList
    {
        $pagePostIDs = SiteTree::get()->filter('URLSegment', $this->getRequest()->param('URLSegment'))->first()->Posts()->column();
        if ( ($liveBlogPosts = Versioned::get_by_stage(BasePost::class, Versioned::LIVE)) && !empty($pagePostIDs) ) {
            $liveBlogPosts = $liveBlogPosts->filter('ID', $pagePostIDs);

            // cat can be a null or empty string value
            if ($cat = $this->getFilterVar()) {
                $liveBlogPosts = $liveBlogPosts->filter('FilterTags.Title', $cat);
            }

            $pag_list = PaginatedList::create($liveBlogPosts, Controller::curr()->getRequest());
            $pag_list->setPageLength(9);

            return $pag_list;
        }

        return null;
    }

    public function getFilterVar()
    {
        return $this->getRequest()->getVar('cf');
    }

    public function getPostParentPage()
    {
        return SiteTree::get()->filter('URLSegment', $this->getRequest()->param('URLSegment'))->first();
    }
}
