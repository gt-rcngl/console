<?php

namespace Rcngl\Console\Command;

use Rcngl\Console\Executor\CommandHandler;

class Collector
{

    /**
    * $collection - used to store command
    * structure : $collection[$command] => object of command properties
    */
    protected static array $collection = array();


    protected  function __construct(
        protected string $command,
        protected mixed $callback,
        protected ?string $method
    ) {
        self::$collection[$this->command] = new CommandHandler(
            $this->callback, $this->method
        );

    }


    protected static function Add($command, $callback, $method = null)
    {
        return new static($command, $callback, $method);
    }


    public static function test()
    {
        return self::$collection;    
    }

    protected function ProvideCollection() 
    {
        return self::$collection;    
    }

}
