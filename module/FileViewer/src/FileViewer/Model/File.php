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
            case "mp3":
                $type = "html5audio";
                break; 
            case "mp4": case "webm":  case "3gp":
                $type = "html5Video";
                break; 
            case "mpg": case "mpeg": case "avi": case "flv":
                $type = "video";
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
        return !$this->isMedia()? 
            parent::getUrl(): "media/?id=".$this->getLogicalPath();
    }
    
    public function isMedia() {
        return $this->getType() == "image" || $this->getType() == "html5Video";
    }
    

}
