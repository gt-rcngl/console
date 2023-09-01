<?php

namespace Rcngl\Console\Http\Abstract;

use Rcngl\Console\Output\WriteLine;

class KernelAbstract
{
    protected $childClass;

    private const REQUIRED_INTERFACE = 'Rcngl\Console\Http\Interface\KernelInterface';

    public function handle(WriteLine $output)
    {


        if (!$this->childRequiredInterface()) {
            $output::Println(self::REQUIRED_INTERFACE." interface is required to implement in child class", 'red');
            die;
        }
        
        if (!$this->isClassExtended()) {
           
            $output::Println("Cannot use parent kernel", 'red');
            die;
        }

        $this->childClass = static::class;

        $arguments = static::getArguments();
        $getOptions = static::getOptions();
        $getCommand = static::getCommand();

        print_r($getOptions);

    }

    private function childRequiredInterface($childClassName = null) {

        $specificInterfaceName = self::REQUIRED_INTERFACE;

        if (!$this->isClassPropertyExists()) {
            return false;
        }

        $childClassName = (null != $childClassName) ? $childClassName : $this->childClass;
        
        $childReflection = new \ReflectionClass($childClassName);


        if (in_array($specificInterfaceName, $childReflection->getInterfaceNames())) {
            return true;
        }
       return false;
    }

    private function isClassPropertyExists(){
        if (!isset($this->childClass)) {
            return false;
        }
        return true;
    }

    private function isClassExtended() {
        if (!$this->isClassPropertyExists()) {
            return false;
        }

        return is_subclass_of($this->childClass, __CLASS__);
    }
}
