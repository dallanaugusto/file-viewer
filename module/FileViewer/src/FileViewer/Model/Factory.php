<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;

abstract class Factory 
{
    
    public static function getItem($logicalPath) 
    {
        $absolutePath = 
            \getcwd().
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","publicHttpDirectory").
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","dataDirectory").
            ($logicalPath? \DIRECTORY_SEPARATOR.$logicalPath: "");
        if (!\file_exists($absolutePath)) {
            throw new UnknownItemException($logicalPath);
        }
        if (\is_dir($absolutePath))
            return new Directory($logicalPath);
        else
            return new File($logicalPath);
    }
    
    
}
