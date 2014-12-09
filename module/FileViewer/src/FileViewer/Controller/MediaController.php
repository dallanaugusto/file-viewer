<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Model\Factory;

class MediaController extends AbstractActionController
{

    public function indexAction()
    {
        // obtendo mídia
        $mediaPath = isset($_REQUEST["id"])? $_REQUEST["id"]: null;
        $media = $mediaPath? Factory::getItem($mediaPath): null;
        
        // obtendo diretório
        $directory = $media->getParent();
        
        // formando caminho de links do diretório
        $allLogicalPaths = $directory->getAllLogicalPaths();
        
        // obtendo items filhos do diretório
        $items = $directory->getMedias();
        
        // cria thumbnails
        if ($directory->hasMedia())
            $directory->createThumbs();
        
        // obtém mídias anterior e posterior
        $numItems = sizeof($items);
        foreach ($items as $key => $item) {
            if ($item->getLogicalPath() == $mediaPath) {
                $previousMediaId = $key == 0? $numItems - 1: $key -1;
                $nextMediaId = $key == $numItems - 1? 0: $key + 1;
                $previousMedia = $items[$previousMediaId];
                $nextMedia = $items[$nextMediaId];
                break;
            }
        }
        
        // variáveis para view
        $this->layout()->setVariable("pageTitle", $media->getName());
        $this->layout()->setVariable("mediaViewerIsOpen", true);
        return array(
            "media" => $media, "directory" => $directory, 
            "previousMedia" => $previousMedia, "nextMedia" => $nextMedia,
            "items" => $items, "allLogicalPaths" => $allLogicalPaths,
        );
    }


}

