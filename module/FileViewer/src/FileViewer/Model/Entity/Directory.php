<?php

namespace FileViewer\Model\Entity;

class Directory extends Item 
{
    public function createThumbsByIndex($currentMediaIndex)
    {
        $this->getDao()->createThumbsByMediaIndex($currentMediaIndex);
    }
    
    public function getFiles() 
    {
        return $this->getDao()->getFiles();
    }   

    public function getFirstMedia() 
    {
        return $this->getDao()->getFirstMedia();
    }
    
    public function getItems() 
    {
        return $this->getDao()->getItems();
    }  
    
    public function getMedia($mediaIndex) 
    {
        return $this->getDao()->getMedia($mediaIndex);
    }
    
    public function getMediaIndex($media) 
    {
        return $this->getDao()->getMediaIndex($media);
    }  
    
    public function getMedias() 
    {
        return $this->getDao()->getMedias();
    }
    
    public function getMediasByMediaIndex($currentMediaIndex) 
    {
        return $this->getDao()->getMediasByMediaIndex($currentMediaIndex);
    }   
    
    public function getNumMedias() 
    {
        return sizeof($this->getMedias());
    }   
    
    public function getSubDirectories() 
    {
        return $this->getDao()->getSubDirectories();
    } 

    public function getType() 
    {
        return $this->getDao()->getType();
    } 
    
    public function getUrl() 
    {
        return $this->getDao()->getUrl();
    }

    public function hasMedia() 
    {
        return $this->getDao()->hasMedia();
    }
    

}
