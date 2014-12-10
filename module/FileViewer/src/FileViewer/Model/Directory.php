<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;

class Directory extends Item 
{
    private $files;
    private $items;
    private $medias;
    private $subDirectories;
    
    public function createThumbs($currentMediaIndex)
    {
        $pageSize = Configuration::get("custom","pageSize");
        $firstThumb = $currentMediaIndex%$pageSize == 0?
            $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
        $medias = $this->getMedias($currentMediaIndex);
        foreach ($medias as $media) {
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
            if ($media->getType() == "image") {
                // definitions
                $thumbPath = 
                    \getcwd().\DIRECTORY_SEPARATOR.
                    Configuration::get("path","publicHttpDirectory").
                    \DIRECTORY_SEPARATOR.Configuration::get("path","thumbDirectory").
                    \DIRECTORY_SEPARATOR.$media->getLogicalPath();

                // create thumb if it doesn't exist
                if (!file_exists($thumbPath))
                    imagejpeg($media->getThumb(), $thumbPath);

            }
        }
    }
    
    public function getFiles() 
    {
        if (!$this->files) {
            $itemNames = \scandir($this->getAbsolutePath(), 0);
            $this->files = array();
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
                            $this->files[] = $item;
                    }
                }
            }
        }
        return $this->files;
    }   

    public function getFirstMedia() 
    {
        $medias = $this->getMedias();
        return isset($medias[0])? $medias[0]: null;
    }
    
    public function getItems() 
    {
        if (!$this->items) {
            $subDirectories = $this->getSubDirectories();
            $files = $this->getFiles();
            $this->items = array();
            foreach ($subDirectories as $directory)
                $this->items[] = $directory;
            foreach ($files as $file)
                $this->items[] = $file;
        }
        return $this->items;
    }  
    
    public function getMedia($mediaIndex) 
    {
        $medias = $this->getMedias();
        return $medias[$mediaIndex];
    }
    
    public function getMediaIndex($media) 
    {
        $medias = $this->getMedias();
        for ($i = 0; $i < $medias; $i++)
            if ($media->getLogicalPath() == $medias[$i]->getLogicalPath())
                return $i;
    }  
    
    public function getMedias($currentMediaIndex = -1) 
    {
        if ($currentMediaIndex != -1) {
            $pageSize = Configuration::get("custom","pageSize");
            $firstThumb = $currentMediaIndex%$pageSize == 0?
                $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
            $allMedias = $this->getMedias();
            $numMedias = sizeof($allMedias);
            $medias = array();
            for ($i = 0; $i < $pageSize; $i++) {
                if ($i+$firstThumb >= $numMedias)
                    break;
                $medias[] = $allMedias[$i+$firstThumb];
            }
            return $medias;
        }
        else {
            if (!$this->medias) {
                $this->medias = array();
                $files = $this->getFiles();
                foreach ($files as $file)
                    if ($file->isMedia())
                        $this->medias[] = $file;
            }
            return $this->medias;
        }
        return $medias;
    }   
    
    public function getNumMedias() 
    {
        return sizeof($this->getMedias());
    }    
    
    public function getSubDirectories() 
    {
        if (!$this->subDirectories) {
            $itemNames = \scandir($this->getAbsolutePath(), 0);
            $this->subDirectories = array();
            foreach ($itemNames as $itemName) {
                if ($itemName != "." && $itemName != ".." && \substr($itemName,0,1) != ".") {
                    $absoluteItemName = $this->getAbsolutePath()."/".$itemName;
                    if (\is_dir($absoluteItemName))
                        $this->subDirectories[] = Factory::getItem(
                            $this->getLogicalPath().
                            ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                            $itemName
                        );
                }
            }
        }
        return $this->subDirectories;
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
