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
    
    public function getThumbUrl() 
    {
        return $this->getDao()->getThumbUrl();
    }
    
    public function isBlocked() 
    {
        // return if the file is blocked to show
        return $this->getDao()->isBlocked();
    }  
    
    public function isHtml5Audio() 
    {
        return $this->getDao()->isHtml5Audio();
    }  
    
    public function isHtml5Video() 
    {
        return $this->getDao()->isHtml5Video();
    }  
    
    public function isImage() 
    {
        return $this->getDao()->isImage();
    }
    
    public function isMedia() 
    {
        return $this->getDao()->isMedia();
    }
    

}
