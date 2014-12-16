<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Entity\File;

class FileDao extends ItemDao
{
    
    protected static function getInstance($logicalPath)
    {
        return new FileDao($logicalPath);
    }
    
    public static function getNewObject($logicalPath)
    {
        $dao = self::getInstance($logicalPath);      
    
        $itemArray = $dao->getItemDescription($logicalPath);
        
        if ($itemArray["type"] == "file") {
            $file = new File($logicalPath);
            $dao->setObject($file);
            $file->setDao($dao);
            return $file;
        }
        else
            throw new \Exception("O item $logicalPath não é um arquivo");
    } 
    
    public function getThumb()
    {
        if ($this->getType() == "image") {
            // definitions
            $maxThumbSize = Configuration::get("custom","thumbSize");

            // return the thumbnail
            return $this->getDataDirectoryPersistence()->getJpegImageFileAndResize(
                $this->getLogicalPath(), $maxThumbSize
            );
        }
        return null;
    }  
    
    public function getType() 
    {
        $pathInfo = \pathinfo($this->getAbsolutePath());
        $extension = isset($pathInfo["extension"])?
            \strtolower($pathInfo["extension"]): "";
        $type = Configuration::get("file-type",$extension);
        return $type? $type: "unknown";
    }
    
    public function getUrl() 
    {
        return !$this->isMedia()? 
            parent::getUrl(): "media/?id=".str_replace(' ','%20',\urlencode($this->getLogicalPath()));
    }
    
    public function getThumbUrl() {
        return str_replace(
            ' ','%20',Configuration::get("path","thumbDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    public function isMedia() {
        return 
            $this->getType() == "image" || $this->getType() == "html5Video" ||
            $this->getType() == "html5Audio";
    }    
    
    
}
