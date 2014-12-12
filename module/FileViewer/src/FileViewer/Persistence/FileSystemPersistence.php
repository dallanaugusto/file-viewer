<?php

namespace FileViewer\Persistence;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Directory;
use FileViewer\Model\File;

class FileSystemPersistence {
    
    public function createThumbsFromDirectoryAndItemIndex(Directory $directory, $currentMediaIndex)
    {
        $pageSize = Configuration::get("custom","pageSize");
        $firstThumb = $currentMediaIndex%$pageSize == 0?
            $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
        $medias = $this->getMediasFromDirectory($directory, $currentMediaIndex);
        foreach ($medias as $media) {
            // definitions
            $thumbDirPath = 
                \getcwd().\DIRECTORY_SEPARATOR.
                Configuration::get("path","publicHttpDirectory").
                \DIRECTORY_SEPARATOR.Configuration::get("path","thumbDirectory").
                \DIRECTORY_SEPARATOR.$directory->getLogicalPath();
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
    
    public function getItemByAbsolutePath($absolutePath) 
    {
        if (!$this->isValidItem($absolutePath))
            return null;
        else {
            $levels = \explode(\DIRECTORY_SEPARATOR, $absolutePath);
            $lastLevel = \sizeof($levels) - 1;
            $itemName = $levels[$lastLevel];
            if (\is_dir($absolutePath)) {
                $type = "directory";
                $extension = "";
            }
            else {
                $type = "file";
                $pathInfo = \pathinfo($absolutePath);
                $extension = isset($pathInfo["extension"])?
                    \strtolower($pathInfo["extension"]): "";
            }
            return array(
                "type" => $type, "absolutePath" => $absolutePath, 
                "name" => $itemName, "extension" => $extension,
            );
        }
    }
    
    public function getFilesFromDirectory($absolutePath) 
    {        
        $items = $this->getItemsFromDirectory($absolutePath);
        $files = array();
        foreach ($items as $item)
            if ($item["type"] == "file")
                $files[] = $item;
        return $files;
    }  
    
    public function getItemsFromDirectory($absolutePath) 
    {
        $itemNames = \scandir($absolutePath, 0);
        $items = array();
        foreach ($itemNames as $itemName) {
            if ($itemName != "." && $itemName != "..") {
                $absoluteItemName = $absolutePath."/".$itemName;
                $items[] = $this->getItemByAbsolutePath($absoluteItemName);
            }
        }
        return $items;
    }      
    
    public function getSubDirectoriesFromDirectory($absolutePath) 
    {
        $items = $this->getItemsFromDirectory($absolutePath);
        $subDirectories = array();
        foreach ($items as $item)
            if ($item["type"] == "directory")
                $subDirectories[] = $item;
        return $subDirectories;
    }   
    
    public function isValidItem($absolutePath)
    {            
        return \file_exists($absolutePath);
    }
}
