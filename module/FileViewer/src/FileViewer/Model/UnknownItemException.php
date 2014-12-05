<?php

namespace FileViewer\Model;

class UnknownItemException extends \Exception 
{
    
    private $logicalPath;
    
    public function __construct($logicalPath) 
    {
        parent::__construct("O item $logicalPath não existe");
        $this->logicalPath= $logicalPath;
    }
    
    public function getLogicalPath() 
    {
        return $this->logicalPath;
    }

    
}
