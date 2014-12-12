<?php

namespace FileViewer\Model;

abstract class AbstractModel {
    
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
