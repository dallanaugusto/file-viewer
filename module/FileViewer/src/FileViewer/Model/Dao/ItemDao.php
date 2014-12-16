<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Persistence\FileSystemPersistence;

abstract class ItemDao extends AbstractDao
{
    private $dataDirectoryPersistence;
    private $thumbDirectoryPersistence;
    private $logicalPath;
    private $description;
    
    protected function __construct($logicalPath)
    {
        parent::__construct();
        $this->dataDirectoryPersistence = new FileSystemPersistence(
            \getcwd().
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","publicHttpDirectory").
            \DIRECTORY_SEPARATOR.
            Configuration::get("path","dataDirectory")
        );
        $this->thumbDirectoryPersistence = new FileSystemPersistence(
            \getcwd().\DIRECTORY_SEPARATOR.
            Configuration::get("path","publicHttpDirectory").
            \DIRECTORY_SEPARATOR.Configuration::get("path","thumbDirectory")
        );
        $this->logicalPath = $logicalPath;
    }
    
    public function getAbsolutePath() {
        return $this->description["absolutePath"];
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
    
    public function getDataDirectoryPersistence()
    {
        return $this->dataDirectoryPersistence;
    }
    
    abstract protected static function getInstance($logicalPath);
    
    public function getItemDescription($logicalPath) 
    {
        if (!$this->getDataDirectoryPersistence()->isValidItem($logicalPath))
            throw new \Exception("O item $logicalPath não existe");
        
        $this->description = 
            $this->getDataDirectoryPersistence()->getItemByRelativePath($logicalPath);
        
        return $this->description;
    } 
    
    public function getLogicalPath() {
        return $this->logicalPath;
    }
    
    public function getName() {
        if ($this->getLogicalPath() && $this->getLogicalPath() != ".") {
            return $this->description["name"];
        }
        else
            return "Home";
    }
    
    public function getParent() {
        $lastSlashPos = strrpos($this->getLogicalPath(), "/");
        $logicalParentPath = \substr($this->getLogicalPath(), 0, $lastSlashPos);
        return DirectoryDao::getNewObject($logicalParentPath);
    }
    
    public function getPermissions() {
        return $this->description["permissions"];
    }
    
    public function getDataPath() {
        return str_replace(
            ' ','%20',
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    public function getSize() {
        return $this->description["size"];
    }
    
    public function getShortLabel() {
        return sizeof($this->getName()) > Configuration::get("custom","maxFileLabelSize")?
            \substr($this->getName(), 0, Configuration::get("custom","maxFileLabelSize") - 15)."...".
            \substr($this->getName(), sizeof($this->getName()) - 10, 10): 
            $this->getName();
    }
    
    public function getThumbDirectoryPersistence()
    {
        return $this->thumbDirectoryPersistence;
    }

    abstract public function getType();
    
    public function getUrl() {
        return str_replace(
            ' ','%20',
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    
}
