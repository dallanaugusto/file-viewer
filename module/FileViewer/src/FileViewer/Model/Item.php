<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\AbstractModel;

abstract class Item extends AbstractModel
{
    
    public function getAbsolutePath() {
        return $this->getDao()->getAbsolutePath();
    }
    
    public function getAllLogicalPaths() 
    {
        return $this->getDao()->getAllLogicalPaths();
    } 
    
    public function getLogicalPath() {
        return $this->getDao()->getLogicalPath();
    }
    
    public function getName() {
        return $this->getDao()->getName();
    }
    
    public function getParent() {
        return $this->getDao()->getParent();
    }
    
    public function getPermissions() {
        return $this->getDao()->getPermissions();
    }
    
    public function getRelativePath() {
        return $this->getDao()->getRelativePath();
    }
    
    public function getShortLabel() {
        return $this->getDao()->getShortLabel();
    }
    
    public function getSize() {
        return $this->getDao()->getSize();
    }

    abstract public function getType();
    
    public function getUrl() {
        return $this->getDao()->getUrl();
    }
    
}
