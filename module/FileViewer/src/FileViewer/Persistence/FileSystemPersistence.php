<?php

namespace FileViewer\Persistence;

class FileSystemPersistence {
    
    // set the root directory to make the absolute paths
    private $rootPath;
    
    public function __construct($rootPath = null)
    {
        $this->rootPath = $rootPath;
    }
    
    public function getItemByRelativePath($relativePath) 
    {
        $absolutePath = $this->makeAbsolutePath($relativePath);
        // verify if item is valid
        if (!$this->isValidItem($relativePath))
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
    
    public function getFilesFromDirectory($relativePath) 
    {  
        // get all the items and filter them to choose only the files
        $items = $this->getItemsFromDirectory($relativePath);
        $files = array();
        foreach ($items as $item)
            if ($item["type"] == "file")
                $files[] = $item;
        return $files;
    }  
    
    public function getJpegImageFileAndResize($relativePath, $maxSideSize)
    {
        $absolutePath = $this->makeAbsolutePath($relativePath);
        if ($this->isValidItem($relativePath)) {
            // load image and get image size
            $img = \imagecreatefromjpeg($absolutePath);

            $width = \imagesx($img);
            $height = \imagesy($img);

            // calculate thumbnail size
            $newWidth = $width >= $height?
                $maxSideSize: \floor($width*($maxSideSize/$height));
            $newHeight = $width < $height?
                $maxSideSize: \floor($height*($maxSideSize/$width));
            
            // create a new temporary image
            $newImage = \imagecreatetruecolor($newWidth, $newHeight);
            
            // copy and resize old image into new image
            \imagecopyresized(
                $newImage, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height
            );
            // returning the new image
            return $newImage;
        }
    }
    
    public function getItemsFromDirectory($relativePath) 
    {
        // get all the items
        $absolutePath = $this->makeAbsolutePath($relativePath);
        $itemNames = \scandir($absolutePath, 0);
        $directories = array();
        $files = array();
        foreach ($itemNames as $itemName) {
            if ($itemName != "." && $itemName != "..") {
                $relativeItemName = $relativePath."/".$itemName;
                // put the directories before the files
                if (\is_dir($absolutePath))
                    $directories[] = $this->getItemByRelativePath($relativeItemName);
                else
                    $files[] = $this->getItemByRelativePath($relativeItemName);
            }
        }
        return \array_merge($directories, $files);
    } 
    
    public function getRootPath()
    {
        return $this->rootPath;
    }
    
    public function getSubDirectoriesFromDirectory($relativePath) 
    {
        // get all the items and filter them to choose only the subdirectories
        $items = $this->getItemsFromDirectory($relativePath);
        $subDirectories = array();
        foreach ($items as $item)
            if ($item["type"] == "directory")
                $subDirectories[] = $item;
        return $subDirectories;
    }   
    
    public function isValidItem($relativePath)
    {        
        $absolutePath = $this->makeAbsolutePath($relativePath);
        return \file_exists($absolutePath);
    }
    
    public function makeAbsolutePath($relativePath)
    {
        return $this->getRootPath()."/".$relativePath;
    }
    
    public function makeDirectory($relativePath, $mode = 0777, $recursive = false)
    {
        $absolutePath = $this->makeAbsolutePath($relativePath);
        return \mkdir($absolutePath,$mode,$recursive);
    }
    
    public function makeJpegImageFile($relativePath, $jpegImage)
    {
        $absolutePath = $this->makeAbsolutePath($relativePath);
        return \imagejpeg($jpegImage, $absolutePath);
    }
    
    
}
