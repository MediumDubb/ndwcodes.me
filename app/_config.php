<?php

use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\ORM\Search\FulltextSearchable;

FulltextSearchable::enable();

//Add hr button to tinyMCE
TinyMCEConfig::get('cms')
    ->enablePlugins('codesample')
    ->insertButtonsAfter('code', 'codesample');

