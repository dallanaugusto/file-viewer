<?php

namespace FileViewer\Model\Entity;

class File extends Item 
{
    
    public function getThumb()
    {
        return $this->getDao()->getThumb();
    }
    
    public function getType() 
    {
        return $this->getDao()->getType();
    }
    
    public function getUrl() 
    {
        return $this->getDao()->getUrl();
    }
    
    public function getThumbUrl() {
        return $this->getDao()->getThumbUrl();
    }
    
    public function isMedia() {
        return $this->getDao()->isMedia();
    }    
    

}
