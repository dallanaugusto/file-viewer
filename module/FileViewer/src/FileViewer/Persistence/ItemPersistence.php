<?php

namespace FileViewer\Persistence;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Directory;
use FileViewer\Model\File;

class ItemPersistence {
    
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
    
    public function getFilesFromDirectory(Directory $directory) 
    {        
        $itemNames = \scandir($directory->getAbsolutePath(), 0);
        $files = array();
        foreach ($itemNames as $itemName) {
            if ($itemName != "." && $itemName != ".." && \substr($itemName,0,1) != ".") {
                $absoluteItemName = $directory->getAbsolutePath()."/".$itemName;
                if (!\is_dir($absoluteItemName)) {
                    $item = Factory::getItem(
                        $directory->getLogicalPath().
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

    public function getFirstMediaFromDirectory(Directory $directory) 
    {
        $medias = $this->getMediasFromDirectory();
        return isset($medias[0])? $medias[0]: null;
    }
    
    public function getItemsFromDirectory(Directory $directory) 
    {
        $subDirectories = $this->getSubDirectoriesFromDirectory();
        $files = $this->getFilesFromDirectory();
        $items = array();
        foreach ($subDirectories as $directory)
            $items[] = $directory;
        foreach ($files as $file)
            $items[] = $file;
        return $items;
    }  
    
    public function getMediaFromDirectory($mediaIndex) 
    {
        $medias = $this->getMedias();
        return $medias[$mediaIndex];
    }
    
    public function getMediaIndexFromDirectory(Directory $directory, File $media) 
    {
        $medias = $directory->getMedias();
        for ($i = 0; $i < $medias; $i++)
            if ($media->getLogicalPath() == $medias[$i]->getLogicalPath())
                return $i;
    } 
    
    public function getMediasFromDirectoryAndItemIndex(Directory $directory, $currentMediaIndex = -1) 
    {
        if ($currentMediaIndex != -1) {
            $pageSize = Configuration::get("custom","pageSize");
            $firstThumb = $currentMediaIndex%$pageSize == 0?
                $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
            $allMedias = $this->getMediasFromDirectory($directory);
            $numMedias = sizeof($allMedias);
            $medias = array();
            for ($i = 0; $i < $pageSize; $i++) {
                if ($i+$firstThumb >= $numMedias)
                    break;
                $medias[] = $allMedias[$i+$firstThumb];
            }
        }
        else {
            $medias = $this->getMediasFromDirectory($directory);
        }
        return $medias;
    }    
    
    public function getSubDirectoriesFromDirectories(Directory $directory) 
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
    
    
}
