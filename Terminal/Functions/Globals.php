<?php

if (!function_exists('base_path')) {
    function base_path($file){
        $dir = dirname(__FILE__,3);
        if (strpos($file,'/') != 0) {
            $file = "/".$file;
        }
        return str_replace('/',DIRECTORY_SEPARATOR, $dir.$file);
    }
}


if (!function_exists('trim_replace_null')) {
    function trim_replace_null($text, $replace = null){
       $text = trim($text);

       return ("" != $text) ? $text : (($replace !== "") ? $replace : null);
    }
}