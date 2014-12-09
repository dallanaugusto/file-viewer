<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;

abstract class Item 
{
    
    private $logicalPath;
    
    public function __construct($logicalPath) 
    {
        $this->logicalPath = $logicalPath == "."? "": $logicalPath;
    }
    
    public function getAbsolutePath() {
        return 
            \getcwd().
            \DIRECTORY_SEPARATOR.
            "public".
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","dataDirectory").
            ($this->getLogicalPath()? \DIRECTORY_SEPARATOR.$this->getLogicalPath(): "");
    }
    
    public function getAllLogicalPaths() 
    {
        if ($this->getLogicalPath() && $this->getLogicalPath() != "." ) {
            $parentLogicalPath = $this->getParent()->getAllLogicalPaths();
            $allLogicalPaths = array(
                $this->getUrl() => $this->getName()
            );
            return array_merge($parentLogicalPath, $allLogicalPaths);
        }
        else {
            return array("." => "Home");
        }
    } 
    
    public function getLogicalPath() {
        return $this->logicalPath;
    }
    
    public function getName() {
        if ($this->getLogicalPath() && $this->getLogicalPath() != ".") {
            $levels = \explode(\DIRECTORY_SEPARATOR, $this->getLogicalPath());
            $lastLevel = \sizeof($levels) - 1;
            $filename = $levels[$lastLevel];
            return $filename;
        }
        else
            return "Home";
    }
    
    public function getParent() {
        $lastSlashPos = strrpos($this->getLogicalPath(), "/");
        $parentPath = \substr($this->getLogicalPath(), 0, $lastSlashPos);
        return Factory::getItem($parentPath);
    }
    
    public function getRelativePath() {
        return 
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.
            $this->getLogicalPath();
    }
    
    public function getShortLabel() {
        return sizeof($this->getName()) > Configuration::get("custom","maxFileLabelSize")?
            \substr($this->getName(), 0, Configuration::get("custom","maxFileLabelSize") - 15)."...".
            \substr($this->getName(), sizeof($this->getName()) - 10, 10): 
            $this->getName();
    }

    abstract public function getType();
    
    public function getUrl() {
        $url = str_replace(' ','%20',$this->getRelativePath());
        return $url;
    }
    
}