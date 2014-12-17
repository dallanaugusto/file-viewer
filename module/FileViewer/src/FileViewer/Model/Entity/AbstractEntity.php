<?php

namespace FileViewer\Model\Entity;

// used as super clas for all the model entities
abstract class AbstractEntity {
    
    // all the entities must have a Data Access Object
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
