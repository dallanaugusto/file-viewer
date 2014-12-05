<?php

namespace FileViewer\Model;

class File extends Item 
{
    
    public function getType() 
    {
        $pathInfo = \pathinfo($this->getAbsolutePath());
        $extension = isset($pathInfo["extension"])?
            \strtolower($pathInfo["extension"]): "";
        switch ($extension) {
            case "doc": case "docx": case "odt": case "txt": 
                $type = "document";
                break;       
            case "xls": case "xlsx": case "ods":
                $type = "sheet";
                break;  
            case "ppt": case "pptx": case "odp":
                $type = "presentation";
                break;         
            case "pdf":
                $type = "pdf";
                break; 
            case "zip": case "rar": case "gz": case "bz":  
                $type = "compacted";
                break;
            case "png": case "jpg": case "jpeg": case "gif":  
                $type = "image";
                break; 
            case "php": case "htm": case "html": case "asp": case "css": 
            case "js": case "htaccess": case "htpasswd": case "db":              
                $type = "blocked";
                break;
            default:
                $type = "unknown";
                break;
        }    
        return $type;
    }
    
    public function getUrl() 
    {
        return $this->getType() != "image"? 
            parent::getUrl():
            "?controller=media&action=index&id=".$this->getLogicalPath();
    }
    

}
