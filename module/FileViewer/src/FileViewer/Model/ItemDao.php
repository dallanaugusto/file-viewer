<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\AbstractDao;
use FileViewer\Persistence\FileSystemPersistence;

abstract class ItemDao extends AbstractDao
{
    private $fileSystemPersistence;
    private $logicalPath;
    
    protected function __construct($logicalPath)
    {
        parent::__construct();
        $this->fileSystemPersistence = new FileSystemPersistence();
        $this->logicalPath = $logicalPath;
    }
    
    public function getAbsolutePath() {
        return 
            \getcwd().
            \DIRECTORY_SEPARATOR.
            "public".
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","dataDirectory").
            ($this->getLogicalPath()? 
                \DIRECTORY_SEPARATOR.$this->getLogicalPath(): ""
            );
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
    
    public function getFileSystemPersistence()
    {
        return $this->fileSystemPersistence;
    }
    
    abstract protected static function getInstance($logicalPath);
    
    public function getItemDescription($logicalPath) 
    {
        $absolutePath = 
            \getcwd().
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","publicHttpDirectory").
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","dataDirectory").
            ($logicalPath? \DIRECTORY_SEPARATOR.$logicalPath: "");
            
        if (!$this->getFileSystemPersistence()->isValidItem($absolutePath))
            throw new \Exception("O item $logicalPath não existe");
        
        $itemArray = 
            $this->getFileSystemPersistence()->getItemByAbsolutePath($absolutePath);
        
        return $itemArray;
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
        return DirectoryDao::getNewObject($parentPath);
    }
    
    public function getRelativePath() {
        return str_replace(
            ' ','%20',
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.
            $this->getLogicalPath()
        );
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
