<?php

namespace FileViewer\Model\Exception;

class ItIsNotDirectoryException extends \Exception {
    
    private $logicalPath;
    
    public function __construct($logicalPath, $code = 0)
    {
        $message = "O item $logicalPath não é um diretório";
        $previous = null;
        parent::__construct($message, $code, $previous);
        $this->logicalPath = $logicalPath;        
    }
    
    
}