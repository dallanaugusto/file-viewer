<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;

class Directory extends Item 
{
    
    public function createThumbs()
    {
        $files = $this->getMedias();
        if ($files) {
            // definitions
            $thumbDirPath = 
                \getcwd().\DIRECTORY_SEPARATOR.
                Configuration::get("path","publicHttpDirectory").
                \DIRECTORY_SEPARATOR.Configuration::get("path","thumbDirectory").
                \DIRECTORY_SEPARATOR.$this->getLogicalPath();
            // create thumb directory if it doesn't exist
            if (!file_exists($thumbDirPath)) {
                mkdir($thumbDirPath, 0777, true);
                chmod($thumbDirPath, 0777);
            }
            foreach ($files as $file)
                if ($file->getType() == "image") {
                    // definitions
                    $thumbPath = 
                        \getcwd().\DIRECTORY_SEPARATOR.
                        Configuration::get("path","publicHttpDirectory").
                        \DIRECTORY_SEPARATOR.Configuration::get("path","thumbDirectory").
                        \DIRECTORY_SEPARATOR.$file->getLogicalPath();

                    // create thumb if it doesn't exist
                    if (!file_exists($thumbPath))
                        imagejpeg($file->getThumb(), $thumbPath);
                    
                }
        }
    }
    
    public function getFiles() 
    {
        $itemNames = \scandir($this->getAbsolutePath(), 0);
        $files = array();
        foreach ($itemNames as $itemName) {
            if ($itemName != "." && $itemName != ".." && \substr($itemName,0,1) != ".") {
                $absoluteItemName = $this->getAbsolutePath()."/".$itemName;
                if (!\is_dir($absoluteItemName)) {
                    $item = Factory::getItem(
                        $this->getLogicalPath().
                        \DIRECTORY_SEPARATOR.
                        $itemName
                    );
                    if ($item->getType() != "blocked")
                        $files[] = $item;
                }
            }
        }
        return $files;
    }   

    public function getFirstMedia() 
    {
        $medias = $this->getMedias();
        return isset($medias[0])? $medias[0]: null;
    }
    
    public function getItems() 
    {
        $subDirectories = $this->getSubDirectories();
        $files = $this->getFiles();
        $items = array();
        foreach ($subDirectories as $directory)
            $items[] = $directory;
        foreach ($files as $file)
            $items[] = $file;
        return $items;
    }
    
    public function getMedias() 
    {
        $medias = array();
        $files = $this->getFiles();
        foreach ($files as $file)
            if ($file->isMedia())
                $medias[] = $file;
        return $medias;
    }    
    
    public function getSubDirectories() 
    {
        $itemNames = \scandir($this->getAbsolutePath(), 0);
        $subDirectories = array();
        foreach ($itemNames as $itemName) {
            if ($itemName != "." && $itemName != ".." && \substr($itemName,0,1) != ".") {
                $absoluteItemName = $this->getAbsolutePath()."/".$itemName;
                if (\is_dir($absoluteItemName))
                    $subDirectories[] = Factory::getItem(
                        $this->getLogicalPath().
                        ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                        $itemName
                    );
            }
        }
        return $subDirectories;
    } 

    public function getType() 
    {
        return "directory";
    } 
    
    public function getUrl() 
    {
        return str_replace(' ','%20',"directory/?id=".$this->getLogicalPath());
    }

    public function hasMedia() 
    {
        return sizeof($this->getMedias()) > 0;
    }
    

}
