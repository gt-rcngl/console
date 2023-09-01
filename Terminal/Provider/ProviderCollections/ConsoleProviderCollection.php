<?php

namespace Rcngl\Console\Provider\ProviderCollections;

use Rcngl\Console\Command\Collector;

class ConsoleProviderCollection extends Collector
{
    private static $tagCollections = array();
    
    private static $tag = null;
    
    private function __construct($tag) 
    {
        self::$tag = $tag;
    }

    public static function Provide($tag)
    {
        return self::$tagCollections[$tag];
    }

    public static function load($tag) 
    {
        return new self($tag);
    }

    public function base($file)
    {
        include $file;

        $this->addCollectionTag();
    }

    private function addCollectionTag() 
    {
        $collections = $this->ProvideCollection();

        self::$tagCollections[self::$tag] = $collections;
    }

}


