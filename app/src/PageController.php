<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;

    /**
     * @template T of Page
     * @extends ContentController<T>
     */
    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [];

        protected function init()
        {
            $bootstrap_js = THEMES_DIR . '/whittendav/vendor/bootstrap/js/bootstrap.bundle.min.js';
            $bootstrap_css = THEMES_DIR . '/whittendav/vendor/bootstrap/css/bootstrap.min.css';

            $fa_js = THEMES_DIR . '/whittendav/vendor/fontawesome-free/js/all.min.js';
            $fa_css = THEMES_DIR . '/whittendav/vendor/fontawesome-free/css/all.min.css';

            Requirements::css($bootstrap_css);
            Requirements::css($fa_css);
            Requirements::css('//fonts.googleapis.com/css2?family=Meddon&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap');
            Requirements::css(THEMES_DIR . "/whittendav/css/dist/aos.min.css");
            Requirements::themedCSS('dist/styles.min');

            Requirements::javascript($bootstrap_js);
            Requirements::javascript($fa_js);
            Requirements::javascript(THEMES_DIR . "/whittendav/javascript/vendor/aos.min.js");
            Requirements::themedJavascript('vendor/jquery-3.6.0.min');
            Requirements::themedJavascript('script');

            parent::init();
        }
    }
}
