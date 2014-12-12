<?php

namespace FileViewer\Model;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\ItemDao;

class FileDao extends ItemDao
{
    
    protected static function getInstance($logicalPath)
    {
        return new FileDao($logicalPath);
    }
    
    public static function getNewObject($logicalPath)
    {
        $dao = self::getInstance($logicalPath);      
    
        $itemArray = $dao->getItemDescription($logicalPath);
        
        if ($itemArray["type"] == "file") {
            $file = new File($logicalPath);
            $dao->setObject($file);
            $file->setDao($dao);
            return $file;
        }
        else
            throw new \Exception("O item $logicalPath não é um arquivo");
    } 
    
    public function getThumb()
    {
        if ($this->getType() == "image") {
            // definitions
            $thumbSize = Configuration::get("custom","thumbSize");
            $imagePath = $this->getAbsolutePath();
            $imageParentPath = $this->getParent()->getAbsolutePath();

            // load image and get image size
            $img = imagecreatefromjpeg($imagePath);

            $width = imagesx($img);
            $height = imagesy($img);

            // calculate thumbnail size
            $newWidth = $width >= $height?
                $thumbSize: floor($width*($thumbSize/$height));
            $newHeight = $width < $height?
                $thumbSize: floor($height*($thumbSize/$width));

            // create a new temporary image
            $tmpImg = imagecreatetruecolor($newWidth, $newHeight);

            // copy and resize old image into new image
            imagecopyresized($tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // return the thumbnail
            return $tmpImg;
        }
        return null;
    }  
    
    public function getType() 
    {
        $pathInfo = \pathinfo($this->getAbsolutePath());
        $extension = isset($pathInfo["extension"])?
            \strtolower($pathInfo["extension"]): "";
        switch ($extension) {   
            case "php": case "htm": case "html": case "asp": case "css": 
            case "js": case "htaccess": case "htpasswd": case "db":              
                $type = "blocked";
                break;
            case "zip": case "rar": case "gz": case "bz":  
                $type = "compacted";
                break;      
            case "doc": case "docx": case "odt":
                $type = "document";
                break; 
            case "exe": case "bat": case "sh":
                $type = "executable";
                break;
            case "mp3":  case "wav":
                $type = "html5Audio";
                break;
            case "mp4": case "webm":  case "3gp":
                $type = "html5Video";
                break;   
            case "png": case "jpg": case "jpeg": case "gif":  
                $type = "image";
                break;        
            case "pdf":
                $type = "pdf";
                break; 
            case "ppt": case "pptx": case "odp":
                $type = "presentation";
                break;       
            case "xls": case "xlsx": case "ods":
                $type = "sheet";
                break;  
            case "txt": case "sql":
                $type = "text";
                break;
            case "mpg": case "mpeg": case "avi": case "flv":
                $type = "video";
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
            parent::getUrl(): "media/?id=".str_replace(' ','%20',\urlencode($this->getLogicalPath()));
    }
    
    public function getThumbUrl() {
        return str_replace(
            ' ','%20',Configuration::get("path","thumbDirectory").
            \DIRECTORY_SEPARATOR.$this->getLogicalPath()
        );
    }
    
    public function isMedia() {
        return 
            $this->getType() == "image" || $this->getType() == "html5Video" ||
            $this->getType() == "html5Audio";
    }    
    
    
}
