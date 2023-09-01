<?php

namespace Rcngl\Console\Http;

use Rcngl\Console\Provider\ProviderCollections\ConsoleProviderCollection;

class KernelExecute
{

    private $collections;
    
    public function __construct() {
        $this->collections = ConsoleProviderCollection::Provide('console');
    }


    public function getCommand($command) {
        return $this->collections[$command];
    }
    
    
}
