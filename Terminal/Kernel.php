<?php

namespace Rcngl\Console;

use Rcngl\Console\Http\KernelConsoleController;

use Rcngl\Console\Input\InputRequest;

use Rcngl\Console\Output\WriteLine;

class Kernel extends KernelConsoleController 
{
 

    public function __construct(
        private InputRequest $inputRequest
    ) {

        if (trim_replace_null($this->inputRequest->getCommand()) == null) {
            WriteLine::Println("Can't find command.", 'red');
            die();
        }

        $this->setCommand($this->inputRequest->getCommand());

        $this->setArgument($this->inputRequest->getArguments());
        
        $this->setOptions($this->inputRequest->getOptions());

    }

}
