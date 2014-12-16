<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Entity\Directory;

class DirectoryDao extends ItemDao
{
    
    private $files;
    private $items;
    private $medias;
    private $subDirectories;
    
    public function createThumbsByMediaIndex($currentMediaIndex)
    {
        $medias = $this->getMediasByMediaIndex($currentMediaIndex);
        foreach ($medias as $media) {
            // create thumb directory if it doesn't exist
            if (!$this->getThumbDirectoryPersistence()->isValidItem($this->getLogicalPath()))
                if (!$this->getThumbDirectoryPersistence()->makeDirectory(
                    $this->getLogicalPath(), 0777, true
                ))
                    throw new \Exception("Não foi possível criar o diretório ".$this->getLogicalPath()."!");
            if ($media->getType() == "image") {
                // create thumb if it doesn't exist
                if (!$this->getThumbDirectoryPersistence()->isValidItem($media->getLogicalPath()))
                    if (!$this->getThumbDirectoryPersistence()->makeJpegImageFile(
                        $media->getLogicalPath(),$media->getThumb()
                    ))
                        throw new \Exception(
                            "Não foi possível criar o arquivo ".$this->getLogicalPath()." com imagem JPEG!"
                        );
            }
        }
    }
    
    public function getFiles() 
    {
        if (!$this->files) {
            $filesArray = 
                $this->getDataDirectoryPersistence()->
                    getFilesFromDirectory($this->getLogicalPath());
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
        if (!$this->items) 
            $this->items = \array_merge($this->getSubDirectories(),$this->getFiles());
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
                $this->getDataDirectoryPersistence()
                    ->getSubDirectoriesFromDirectory($this->getLogicalPath());
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
