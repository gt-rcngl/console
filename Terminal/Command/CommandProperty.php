<?php

namespace Rcngl\Console\Command;

class CommandProperty
{
    protected $command;

    protected $callback;

    protected $method;


    public function getCommand() {
        return $this->command;
    }

    public function getCallback(){
        return $this->callback;
    }

    public function callbackType()
    {
        return gettype($this->callback);
    }

    public function getMethod()
    {
        return $this->method;
    }
}
