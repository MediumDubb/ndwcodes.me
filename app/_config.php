<?php

use SilverStripe\ORM\Search\FulltextSearchable;
use SilverStripe\TinyMCE\TinyMCEConfig;

FulltextSearchable::enable();

//Add hr button to tinyMCE
TinyMCEConfig::get('cms')
    ->enablePlugins('codesample')
    ->insertButtonsAfter('code', 'codesample');

