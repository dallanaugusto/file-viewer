<?php

namespace FileViewer\Model\Dao;

abstract class AbstractDao {
    
    private $object;
    
    protected function __construct()
    {
        $this->object = null;
    }
    
    protected function getObject()
    {
        return $this->object;
    }
    
    protected function setObject($object)
    {
        $this->object = $object;
    }
    
    
}
