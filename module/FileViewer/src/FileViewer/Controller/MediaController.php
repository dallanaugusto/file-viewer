<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Factory;

class MediaController extends AbstractActionController
{

    public function indexAction()
    {
        // obtendo mídia
        $mediaPath = isset($_REQUEST["id"])? $_REQUEST["id"]: null;
        $media = $mediaPath? Factory::getItem($mediaPath): null;
        
        // obtendo paginação
        $pageSize = Configuration::get("custom", "pageSize");
        
        // obtendo diretório
        $directory = $media->getParent();
        
        // formando caminho de links do diretório
        $allLogicalPaths = $directory->getAllLogicalPaths();
        
        // índice da mídia atual no diretório
        $currentMediaIndex = $directory->getMediaIndex($media);
        
        // obtendo items filhos do diretório
        $items = $directory->getMedias($currentMediaIndex);
        $allItems = $directory->getMedias();
        $numItems = sizeof($allItems);
        
        // cria thumbnails        
        if ($directory->hasMedia())
            $directory->createThumbs($currentMediaIndex);
        
        // mídias anteriores e posteriores
        $previousMediaId = $currentMediaIndex == 0? 
            $numItems - 1: $currentMediaIndex -1;
        $nextMediaId = $currentMediaIndex == $numItems - 1? 
            0: $currentMediaIndex + 1;
        $previousMedia = $directory->getMedia($previousMediaId);
        $nextMedia = $directory->getMedia($nextMediaId);
        
        // variáveis para view
        $this->layout()->setVariable("pageTitle", $media->getName());
        $this->layout()->setVariable("mediaViewerIsOpen", true);
        return array(
            "media" => $media, "pageSize" => $pageSize, "directory" => $directory, 
            "previousMedia" => $previousMedia, "nextMedia" => $nextMedia,
            "items" => $items, "allItems" => $allItems, 
            "currentMediaIndex" => $currentMediaIndex, 
            "allLogicalPaths" => $allLogicalPaths,
        );
    }


}

