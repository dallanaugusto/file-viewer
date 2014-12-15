<?php

namespace FileViewer\Persistence;

class FileSystemPersistence {
    
    public function getItemByAbsolutePath($absolutePath) 
    {
        if (!$this->isValidItem($absolutePath))
            return null;
        else {   
            // find the last occurence of a slash
            $lastSlashPos = strrpos($absolutePath, "/");
            // find the item infos
            $parentPath = \dirname($absolutePath);
            $name = \substr($absolutePath, $lastSlashPos+1);
            $permissions = substr(sprintf('%o', fileperms($absolutePath)), -4);
            $mtime = filemtime($absolutePath);
            $size = \filesize($absolutePath);
            // get the item type
            $type = \is_dir($absolutePath)? "directory": "file";
            $isFile = $type == "file";
            // get the item extension
            $pathInfo = \pathinfo($absolutePath);
            $extension = $isFile && isset($pathInfo["extension"])?
                \strtolower($pathInfo["extension"]): "";
            // return the item array
            return array(
                "absolutePath" => $absolutePath, "extension" => $extension,
                "mtime" => $mtime, "name" => $name, "parentPath" => $parentPath, 
                "permissions" => $permissions, "size" => $size, "type" => $type, 
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
