<?php

namespace Rcngl\Console\Collection;

use Rcngl\Console\Command\Collector;

class Collection extends Collector 
{

    public static function Command($command, $callback, $method = null) {
        parent::Add($command, $callback, $method);
    }

}
