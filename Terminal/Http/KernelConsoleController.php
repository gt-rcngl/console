<?php

namespace Rcngl\Console\Http;

use Rcngl\Console\Provider\CommandProvider;
use stdClass;

class KernelConsoleController
{
    private $arguments;

    private $options;

    private $command;

    protected function setCommand($command) 
    {
        $this->command = $command;    
    }

    protected function setArgument($arg) 
    {
        $this->arguments = $arg;    
    }

    protected function setOptions($options) 
    {
        $this->options = $options;    
    }

    public function handle() {
        
        (new CommandProvider()) 
            ->boot();

        $KernelExecute = new KernelExecute();

        $command =  $KernelExecute->getCommand($this->command);


        $parameters = [];
        if ($command->hasParameter()) {
            $callbackParam = $command->getCallbackParameters();

            $std = new stdClass();
            
            $std->getArguments = $this->arguments;
            $std->getOptions = $this->options;
            
            $c = 0;
            foreach ($callbackParam as $key => $value) {
                if ($c > 0) {
                   $parameters[] = null;
                }else{
                     $parameters[] = $std;
                }

                $c++;
            }

        }

        return $command->Execute($parameters);


    }

}
