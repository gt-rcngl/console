<?php

namespace Rcngl\Console\Input;
use Rcngl\Console\Input\InputOptions;

abstract class InputParser
{
    private $prefix = "app";

    protected $arguments = [];

    protected $options = [];

    protected $command = null;


    public function getArguments()
    {
        return $this->arguments;
    }

    public function getOptions()
    {
        return $this->options;
    }

    private function setCommand($arg)
    {
        $command = null;
           
        if (strpos($arg,$this->prefix) > -1) {
            $command = str_replace($this->prefix.":",'',$arg);
            $this->command = $command;
            return false;
        }

        return true;

    }

    public function getCommand()
    {
        return $this->command;
    }

    protected function parseArguments($argument)
    {
        if (strpos($argument, '--') === 0) {
            // Process long option
            $this->longOption($argument);
        } elseif (strpos($argument, '-') === 0) {
            // Process short option
            $this->shortOption($argument);
        } else {
            // Process argument
            if ($this->setCommand($argument)) {
                $this->arguments[] = $argument;
            }
        }
    }

    protected function longOption($option)
    {
        // Extract the long option name and value (if present)
        $optionName = substr($option, 2);
        $optionValue = null;

        if (strpos($optionName, '=') !== false) {
            // If the option has an associated value (e.g., --option=value)
            list($optionName, $optionValue) = explode('=', $optionName, 2);
        }

        // Store the long option and its value (if any)
        $this->options[] = InputOptions::construct(
            name: $optionName,
            isLongOption: true,
            value: $optionValue
        );
    }

    protected function shortOption($option)
    {
        // Extract the short option name
        $optionName = substr($option, 1);

        if (strlen($optionName) > 1) {
            // If the option is a combination of characters (e.g., -abc)
            $chars = str_split($optionName);

            foreach ($chars as $char) {
                // Store each character as a separate short option
                $this->options[] = InputOptions::construct(
                    name: $char
                );
            }
        } else {
            // Store the short option
            $this->options[] = InputOptions::construct(
                name: $optionName
            );
        }
    }
}
