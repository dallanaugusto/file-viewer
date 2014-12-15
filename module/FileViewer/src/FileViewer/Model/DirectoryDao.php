<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\FileDao;
use FileViewer\Model\ItemDao;
use FileViewer\Persistence\FileSystemPersistence;

class DirectoryDao extends ItemDao
{
    
    private $files;
    private $medias;
    private $subDirectories;
    
    public function createThumbsByMediaIndex($currentMediaIndex)
    {
        $pageSize = Configuration::get("custom","pageSize");
        $firstThumb = $currentMediaIndex%$pageSize == 0?
            $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
        $medias = $this->getMediasByMediaIndex($currentMediaIndex);
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
                if (!\file_exists($thumbPath))
                    imagejpeg($media->getThumb(), $thumbPath);
            }
        }
    }
    
    public function getFiles() 
    {
        if (!$this->files) {
            $absolutePath = $this->getAbsolutePath();
            $filesArray = 
                $this->getFileSystemPersistence()->getFilesFromDirectory($absolutePath);
            $this->files = array();
            foreach ($filesArray as $item)
                if (\substr($item["name"],0,1) != ".") {
                    $file = FileDao::getNewObject(
                        $this->getLogicalPath().
                        ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                        $item["name"]
                    );
                    if ($file->getType() != "blocked")
                        $this->files[] = $file;
                }
        }
        return $this->files;
    } 

    public function getFirstMedia() 
    {
        $medias = $this->getMedias();
        return isset($medias[0])? $medias[0]: null;
    }
    
    protected static function getInstance($logicalPath)
    {
        return new DirectoryDao($logicalPath);
    }
    
    public function getItems() 
    {
        $itemsArray = 
            $this->getFileSystemPersistence()
                ->getItemsFromDirectory($this->getAbsolutePath());
        foreach ($itemsArray as $item)
            if (\substr($item["name"],0,1) != ".")
                $items[] = $this->getItem(
                    $this->getLogicalPath().
                    ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                    $item["name"]
                );
        return $items;
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
    
    public function getMedias()
    {
        if (!$this->medias) {
            $files = $this->getFiles();
            $this->medias = array();
            foreach ($files as $file)
                if ($file->isMedia())
                    $this->medias[] = $file;
        }
        return $this->medias;
    }
    
    public function getMediasByMediaIndex($currentMediaIndex) 
    {
        $allMedias = $this->getMedias();
        $medias = array();
        
        $pageSize = Configuration::get("custom","pageSize");
        $firstThumb = $currentMediaIndex%$pageSize == 0?
            $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
        $numMedias = sizeof($allMedias);
        
        for ($i = 0; $i < $pageSize; $i++) {
            if ($i+$firstThumb >= $numMedias)
                break;
            $medias[] = $allMedias[$i+$firstThumb];
        }
        return $medias;
    }
    
    public static function getNewObject($logicalPath)
    {
        $dao = self::getInstance($logicalPath);   
    
        $itemArray = $dao->getItemDescription($logicalPath);
        
        if ($itemArray["type"] == "directory") {
            $directory = new Directory($logicalPath);
            $dao->setObject($directory);
            $directory->setDao($dao);
            return $directory;
        }
            throw new \Exception("O item $logicalPath não é um diretório");
    }
    
    public function getSubDirectories()
    {
        if (!$this->subDirectories) {
            $subDirectoriesArray = 
                $this->getFileSystemPersistence()
                    ->getSubDirectoriesFromDirectory($this->getAbsolutePath());
            $this->subDirectories = array();
            foreach ($subDirectoriesArray as $item)
                if (\substr($item["name"],0,1) != ".")
                    $this->subDirectories[] = $this->getNewObject(
                        $this->getLogicalPath().
                        ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                        $item["name"]
                    );
        }
        return $this->subDirectories;
    }

    public function getType() 
    {
        return "directory";
    } 
    
    public function getUrl() 
    {
        return "directory/?id=".str_replace(' ','%20',\urlencode($this->getLogicalPath()));
    }

    public function hasMedia() 
    {
        return sizeof($this->getMedias()) > 0;
    }
    
    
}
