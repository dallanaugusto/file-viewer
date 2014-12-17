<?php

namespace FileViewer\Model\Exception;

class ItIsNotItemException extends \Exception {
    
    private $logicalPath;
    
    public function __construct($logicalPath, $code = 0)
    {
        $message = "O item $logicalPath não existe";
        $previous = null;
        parent::__construct($message, $code, $previous);
        $this->logicalPath = $logicalPath;        
    }
    
    
}