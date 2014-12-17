<?php

namespace FileViewer\Model\Exception;

class CantCreateItemException extends \Exception {
    
    private $logicalPath;
    
    public function __construct($logicalPath, $code = 0)
    {
        $message = 
            "Não foi possível criar o item ".$logicalPath." com imagem JPEG!";
        $previous = null;
        parent::__construct($message, $code, $previous);
        $this->logicalPath = $logicalPath;        
    }
    
    
}
