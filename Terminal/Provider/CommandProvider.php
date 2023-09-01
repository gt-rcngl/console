<?php


namespace Rcngl\Console\Provider;

use Rcngl\Console\Provider\ProviderCollections\ConsoleProviderCollection;

class CommandProvider
{

    public function boot() 
    {
       
        ConsoleProviderCollection::load('console')
            ->base(base_path('/route/Console.php'));

    }
    
}
