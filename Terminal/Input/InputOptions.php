<?php


namespace Rcngl\Console\Input;

class InputOptions
{
    private $name;
    private $value = null;
    public bool $hasValue = false;
    public bool $isLongOption = false;
    public bool $isShortption = false;

    private function __construct($name, $isLongOption, $value) {

        $this->name = $name;
        $this->value = $value;
        $this->hasValue = (null != $value) ? true: false;
        $this->isLongOption = (false !== $isLongOption) ? true: false;
        $this->isShortption = (true !== $isLongOption) ? true: false;

    }

    public static function construct($name, $isLongOption = false, $value = null)
    {
        return new self($name, $isLongOption, $value);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

  
    
}
