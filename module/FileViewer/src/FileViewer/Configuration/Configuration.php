<?php

namespace FileViewer\Configuration;

abstract class Configuration 
{
    
    public static function get($section, $variable) 
    {
        $config = \parse_ini_file(__DIR__."/../../../config/config.ini", true);
        return isset($config[$section][$variable])? 
            $config[$section][$variable]: null;
    }

    
}
