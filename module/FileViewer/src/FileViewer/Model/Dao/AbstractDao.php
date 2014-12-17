<?php

namespace FileViewer\Model\Dao;

// all the DAOs classes has to extend this one
abstract class AbstractDao {
    
    // object refers to the model entity which depends on this DAO to access 
    // its data
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
