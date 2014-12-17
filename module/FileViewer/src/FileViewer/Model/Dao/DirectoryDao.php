<?php

namespace FileViewer\Model\Dao;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Entity\Directory;
use FileViewer\Model\Exception\CantCreateItemException;
use FileViewer\Model\Exception\ItIsNotDirectoryException;

class DirectoryDao extends ItemDao
{
    // these attributes are used as data caches to avoid the massive 
    // persistence access. When a data is first read, it won't be necessary 
    // to do it again
    private $files;
    private $items;
    private $medias;
    private $subDirectories;
    
    public function createThumbsByMediaIndex($currentMediaIndex)
    {
        // get all the medias in the same page of the given index. In fact, it 
        // will only be generated some thumbnails, not all the thumbnails of the 
        // directory
        $medias = $this->getMediasByMediaIndex($currentMediaIndex);
        foreach ($medias as $media) {
            // create thumb directory if it doesn't exist
            if (!$this->getThumbDirectoryPersistence()->isValidItem($this->getLogicalPath()))
                if (!$this->getThumbDirectoryPersistence()->makeDirectory(
                    $this->getLogicalPath(), 0777, true
                ))
                    throw new CantCreateItemException($this->getLogicalPath());
            if ($media->isImage()) {
                // create thumb if it doesn't exist
                if (!$this->getThumbDirectoryPersistence()->isValidItem($media->getLogicalPath()))
                    if (!$this->getThumbDirectoryPersistence()->makeJpegImageFile(
                        $media->getLogicalPath(),$media->getThumb()
                    ))
                        throw new CantCreateItemException($media->getLogicalPath());
            }
        }
    }
    
    public function getFiles() 
    {
        // it uses a data cache to store the file records when they are first read. 
        // Next time, it won't be necessary get the information again.
        if (!$this->files) {
            $filesArray = 
                $this->getDataDirectoryPersistence()->
                    getFilesFromDirectory($this->getLogicalPath());
            $this->files = array();
            foreach ($filesArray as $item)
                // ignore the hidden files
                if (\substr($item["name"],0,1) != ".") {
                    $file = FileDao::getNewObject(
                        $this->getLogicalPath().
                        ($this->getLogicalPath()? \DIRECTORY_SEPARATOR: "").
                        $item["name"]
                    );
                    // and ignore the blocked files
                    if (!$file->isBlocked())
                        $this->files[] = $file;
                }
        }
        // if it was ever read, it's not necessary do it again
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
        // it uses a data cache to store the item records when they are first read. 
        // Next time, it won't be necessary get the information again.
        if (!$this->items) 
            $this->items = \array_merge($this->getSubDirectories(),$this->getFiles());
        // if it was ever read, it's not necessary do it again
        return $this->items;
    }
    
    // get media by its index
    public function getMedia($mediaIndex) 
    {
        $medias = $this->getMedias();
        return $medias[$mediaIndex];
    }
    
    // get index media
    public function getMediaIndex($media) 
    {
        $medias = $this->getMedias();
        for ($i = 0; $i < $medias; $i++)
            if ($media->getLogicalPath() == $medias[$i]->getLogicalPath())
                return $i;
    } 
    
    public function getMedias()
    {
        // it uses a data cache to store the media records when they are first read. 
        // Next time, it won't be necessary get the information again.
        if (!$this->medias) {
            $files = $this->getFiles();
            $this->medias = array();
            // get all files and filter the medias only.
            foreach ($files as $file)
                if ($file->isMedia())
                    $this->medias[] = $file;
        }
        // if it was ever read, it's not necessary do it again
        return $this->medias;
    }
    
    public function getMediasByMediaIndex($currentMediaIndex) 
    {
        // at first, get all medias of this directory
        $allMedias = $this->getMedias();
        $medias = array();
        
        // determine how many medias we have to get from directory
        $pageSize = Configuration::get("custom","pageSize");
        $firstThumb = $currentMediaIndex%$pageSize == 0?
            $currentMediaIndex: $currentMediaIndex - ($currentMediaIndex%$pageSize);
        $numMedias = \sizeof($allMedias);
        
        // take the necessary medias only
        for ($i = 0; $i < $pageSize; $i++) {
            if ($i+$firstThumb >= $numMedias)
                break;
            $medias[] = $allMedias[$i+$firstThumb];
        }
        return $medias;
    }
    
    // we can't instante a directoryDao directly. This is not possible because 
    // creating a directory DAO involves also creating the associated object 
    // (entity). 
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
            throw new ItIsNotDirectoryException($logicalPath);
    }
    
    public function getSubDirectories()
    {
        // it uses a data cache to store the subdirectory records when they are 
        // first read. Next time, it won't be necessary get the information 
        // again.
        if (!$this->subDirectories) {
            $subDirectoriesArray = 
                $this->getDataDirectoryPersistence()
                    ->getSubDirectoriesFromDirectory($this->getLogicalPath());
            $this->subDirectories = array();
            foreach ($subDirectoriesArray as $item)
                // ignore hidden items
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
