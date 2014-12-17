<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Exception\ItIsNotItemException;
use FileViewer\Persistence\FileSystemPersistence;

abstract class ItemDao extends AbstractDao
{
    private $dataDirectoryPersistence;
    private $description;
    private $logicalPath;
    private $thumbDirectoryPersistence;
    
    // this constructor is protected because it can just be called by the 
    // getNewObject function
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
            return \array_merge($parentLogicalPath, $allLogicalPaths);
        }
        else {
            return array("." => "Home");
        }
    } 
    
    public function getDataDirectoryPersistence()
    {
        return $this->dataDirectoryPersistence;
    }
    
    public function getDataPath() {
        return \str_replace(
            ' ','%20',
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    public function getExtension() {
        return $this->description["extension"];
    }
    
    // used by getNewObject function
    abstract protected static function getInstance($logicalPath);
    
    // returns the item description array, which can be a directory or file
    public function getItemDescription($logicalPath) 
    {
        if (!$this->getDataDirectoryPersistence()->isValidItem($logicalPath))
            throw new ItIsNotItemException($logicalPath);
        
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
    
    // we can't instante a Dao directly. This is not possible because 
    // creating a DAO involves also creating the associated object 
    // (entity). That's a complex operation to be made in a constructor
    abstract public static function getNewObject($logicalPath);
    
    public function getParent() {
        if ($this->getLogicalPath()) {
            $lastSlashPos = \strrpos($this->getLogicalPath(), "/");
            $logicalParentPath = \substr($this->getLogicalPath(), 0, $lastSlashPos);
            return DirectoryDao::getNewObject($logicalParentPath);
        }
        return null;
    }
    
    public function getPermissions() {
        return $this->description["permissions"];
    }
    
    public function getSize() {
        return $this->description["size"];
    }
    
    public function getShortLabel() {
        return \sizeof($this->getName()) > Configuration::get("custom","maxFileLabelSize")?
            \substr($this->getName(), 0, Configuration::get("custom","maxFileLabelSize") - 15)."...".
            \substr($this->getName(), \sizeof($this->getName()) - 10, 10): 
            $this->getName();
    }
    
    public function getThumbDirectoryPersistence()
    {
        return $this->thumbDirectoryPersistence;
    }

    abstract public function getType();
    
    public function getUrl() {
        return \str_replace(
            ' ','%20',
            Configuration::get("path","dataDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    
}
