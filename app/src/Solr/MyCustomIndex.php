<?php

namespace SirNoah\Whittendav\Solr;

use SilverStripe\Assets\File;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\FullTextSearch\Solr\SolrIndex;
use SirNoah\Whittendav\Models\Project;

class MyCustomIndex extends SolrIndex
{
    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->addClass(File::class);
        $this->addClass(SiteTree::class);
        $this->addClass(Blog::class);
        $this->addClass(BlogPost::class);
        $this->addClass(Project::class);
        $this->addFulltextField('ClassName');
        $this->addFulltextField('FileFilename');
        $this->addFulltextField('FileHash');
        $this->addFulltextField('Title');
        $this->addFulltextField('Content');
        $this->addFulltextField('TagValues');
        $this->addFulltextField('FileContent');
    }

}
