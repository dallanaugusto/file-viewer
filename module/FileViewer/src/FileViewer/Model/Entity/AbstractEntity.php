<?php

namespace FileViewer\Model\Entity;

abstract class AbstractEntity {
    
    private $dao;
    
    public function getDao()
    {
        return $this->dao;
    }
    
    public function setDao($dao)
    {
        $this->dao = $dao;
    }
    
    
}
