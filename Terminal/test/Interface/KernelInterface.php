<?php
namespace Rcngl\Console\Http\Interface;

interface KernelInterface
{

    public function getArguments();
    
    public function getOptions();

    public function getCommand();

}