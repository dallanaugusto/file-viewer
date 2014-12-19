<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Entity\File;
use FileViewer\Model\Exception\ItIsNotFileException;

class FileDao extends ItemDao
{
    
    protected static function getInstance($logicalPath)
    {
        return new FileDao($logicalPath);
    }
    
    // we can't instante a fileDao directly. This is not possible because 
    // creating a file DAO involves also creating the associated object 
    // (entity).
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
            throw new ItIsNotFileException($logicalPath);
    } 
    
    // make a thumbnail from file if it's a image
    public function getThumb()
    {
        if ($this->isImage()) {
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
        // get the extension and choose type by it.
        $extension = $this->getExtension();
        $type = Configuration::get("file-type",$extension);
        return $type? $type: "unknown";
    }
    
    public function getUrl() 
    {
        return !$this->isMedia()? 
            parent::getUrl(): "media/?path=".\str_replace(' ','%20',\urlencode($this->getLogicalPath()));
    }
    
    public function getThumbUrl() {
        return \str_replace(
            ' ','%20',Configuration::get("path","thumbDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    public function isBlocked() {
        // return if the file is blocked to show
        return $this->getType() == "blocked";
    }  
    
    public function isHtml5Audio() {
        return $this->getType() == "html5Audio";
    }  
    
    public function isHtml5Video() {
        return $this->getType() == "html5Video";
    }  
    
    public function isImage() {
        return $this->getType() == "image";
    }    
    
    public function isMedia() {
        // return the HTML5 executable medias only
        return $this->isImage() || $this->isHtml5Audio() || $this->isHtml5Video();
    }    
    
    
}
