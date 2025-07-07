<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;

    class Page extends SiteTree
    {
        private static string $baseFolderName = 'Uploads';

        private static $db = [];

        private static $has_one = [];

        public function getBaseFolderName()
        {
            return self::$baseFolderName;
        }
    }
}
