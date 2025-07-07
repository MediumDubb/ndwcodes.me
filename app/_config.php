<?php

use SilverStripe\FullTextSearch\Solr\Services\Solr4Service;
use SilverStripe\FullTextSearch\Solr\Solr;
use SilverStripe\ORM\Search\FulltextSearchable;

FulltextSearchable::enable();

Solr::configure_server([
    'host' => 'localhost', // The host or IP address that Solr is listening on
    'port' => '8983', // The port Solr is listening on
    'path' => '/solr', // The suburl the Solr service is available on
    'version' => '4', // Solr server version - currently only 3 and 4 supported
    'service' => Solr4Service::class, // The class that provides actual communcation to the Solr server
    'extraspath' => BASE_PATH .'/vendor/silverstripe/fulltextsearch/conf/solr/4/extras/', // Absolute path to the folder containing templates used for generating the schema and field definitions
    'templates' => BASE_PATH . '/vendor/silverstripe/fulltextsearch/conf/solr/4/templates/', // Absolute path to the configuration default files, e.g. solrconfig.xml
    'indexstore' => [
        'mode' => 'file', // [REQUIRED] a classname which implements SolrConfigStore, or 'file' or 'webdav'
        'path' => '/Users/noah.whittington/Downloads/solr-4.9.1/example/solr', // [REQUIRED] The (locally accessible) path to write the index configurations to OR The suburl on the Solr host that is set up to accept index configurations via webdav (e.g. BASE_PATH . '/.solr')
        'remotepath' => '/Users/noah.whittington/Downloads/solr-4.9.1/example/solr', // The path that the Solr server will read the index configurations from
        'port' => '8983' // The port for WebDAV if different from the Solr port
    ]
]);
