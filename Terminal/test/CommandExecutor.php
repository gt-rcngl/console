<?php

namespace Rcngl\Console;

use Rcngl\Console\Input\InputParser;
use ReflectionClass;

class CommandExecutor
{
    private $inputParser;
    private $commands = [];

    public function __construct(InputParser $inputParser)
    {
        $this->inputParser = $inputParser;
    }

    public function registerCommand(string $command, $callback, $method = 'execute')
    {
        $this->commands[$command] = [
            'callback' => $callback,
            'method' => $method,
        ];
    }

    public function execute()
    {
        $arguments = $this->inputParser->getArguments();
        $options = $this->inputParser->getOptions();


        // Iterate over the registered commands
        foreach ($this->commands as $command => $config) {
            // Check if the command matches the input arguments
            if ($command === $arguments[0]) {
                // Remove the command from arguments
                array_shift($arguments);

                $callback = $config['callback'];
                $method = $config['method'];

                // Execute the callback or instantiate the class
                if (is_callable($callback)) {
                    $callback($arguments, $options);
                } elseif (class_exists($callback)) {
                    $classInstance = $this->instantiateClass($callback);
                    $this->callClassMethod($classInstance, $method, $arguments, $options);
                } else {
                    echo "Command not found.\n";
                }

                return;
            }
        }

        echo "Command not found.\n";
    }

    private function instantiateClass($className)
    {
        $reflectionClass = new ReflectionClass($className);

        // Check if the class can be instantiated
        if ($reflectionClass->isInstantiable()) {
            return $reflectionClass->newInstance();
        }

        echo "Class instantiation failed.\n";
        return null;
    }

    private function callClassMethod($classInstance, $methodName, $arguments, $options)
    {
        if ($classInstance === null) {
            echo "class instance cannot be null";
            exit;
        }


        $reflectionClass = new ReflectionClass($classInstance);

        // Check if the class method exists and is callable
        if ($reflectionClass->hasMethod($methodName) && $reflectionClass->getMethod($methodName)->isPublic()) {
            $classMethod = $reflectionClass->getMethod($methodName);
            $classMethodParams = $classMethod->getParameters();
            $methodArgs = [];

            $methodArgs[] = $arguments;
            $methodArgs[] = $options;


            // // Prepare the arguments for the method
            // foreach ($classMethodParams as $param) {
            //     $paramName = $param->getName();

            //     if ($paramName === 'arguments') {
            //     } elseif ($paramName === 'options') {
            //     } else {
            //         echo "Invalid parameter name: $paramName\n";
            //         return;
            //     }
            // }

            // Execute the class method with the prepared arguments
            $classMethod->invokeArgs($classInstance, $methodArgs);
        } else {
            echo "Method $methodName does not exist or is not accessible.\n";
        }
    }

}
