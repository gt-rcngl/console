<?php

namespace Rcngl\Console\Input;

use Rcngl\Console\Input\Parser;

class InputRequest extends InputParser
{
    protected $token;
  
    public function __construct(array $input = null)
    {
        // Set the input arguments to be parsed
        $arguments = $input ?? $_SERVER['argv'] ?? [];

        // Remove the script name from the arguments
        array_shift($arguments);

        // Store the remaining arguments in the token property
        $this->token = $arguments;

        // Call the parsing method
        $this->parse();
    }


    protected function parse()
    {
        $arguments = $this->token;

        // Iterate over the arguments
        while (($arg = array_shift($arguments)) !== null) {
            $this->parseArguments($arg);
        }
    }

   
}
