<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Configuration\Configuration;
use FileViewer\Model\Dao\DirectoryDao;
use FileViewer\Model\Dao\FileDao;
use FileViewer\Model\Exception\ItIsNotItemException;

class MediaController extends AbstractActionController
{

    public function indexAction()
    {
        // obtendo caminho da mídia e tamanho da paginação
        $mediaPath = \filter_input(\INPUT_GET,"id");
        $directoryPath = \filter_input(\INPUT_GET,"directory");
        $pageSize = Configuration::get("custom", "pageSize");
        
        if ($mediaPath) {
            // obtendo mídia        
            $media = FileDao::getNewObject($mediaPath);        
            // obtendo diretório
            $directory = $media->getParent();
        }
        else if ($directoryPath) {        
            // obtendo diretório
            $directory = DirectoryDao::getNewObject($directoryPath);
            // obtendo mídia        
            $media = $directory->getFirstMedia();
        }
        else
            throw new ItIsNotItemException("");
        
        // formando caminho de links do diretório
        $allLogicalPaths = $directory->getAllLogicalPaths();
        
        // índice da mídia atual no diretório
        $currentMediaIndex = $directory->getMediaIndex($media);
        
        // obtendo items filhos do diretório
        $items = $directory->getMediasByMediaIndex($currentMediaIndex);
        $allItems = $directory->getMedias();
        $numItems = sizeof($allItems);
        
        // cria thumbnails        
        if ($directory->hasMedia())
            $directory->createThumbsByIndex($currentMediaIndex);
        
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
            "media" => $media, "directory" => $directory, "items" => $items, 
            "allItems" => $allItems, "allLogicalPaths" => $allLogicalPaths, 
            "currentMediaIndex" => $currentMediaIndex, "pageSize" => $pageSize, 
            "previousMedia" => $previousMedia, "nextMedia" => $nextMedia,
        );
    }
    
    public function addAction() 
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            // obter dados
            $postData = $request->getPost();
            $mediaPath = $postData['id'];
            // obtendo mídia e diretório
            $media = FileDao::getNewObject($mediaPath);
            $directory = $media->getParent();
            // obtendo mídia anterior
            $mediaIndex = $directory->getMediaIndex($media);
            $previousMedia = $directory->getMedia($mediaIndex-1);
            // retornando informação
            if (!$previousMedia)
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else
                $response->setContent(\Zend\Json\Json::encode(array(
                    'response' => true, 'dataPath' => $previousMedia->getDataPath(),
                    'logicalPath' => $previousMedia->getLogicalPath(),
                )));
        }
        return $response;
    }
    
    public function getPreviousMediaAction() 
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            // obter dados
            $postData = $request->getPost();
            $mediaPath = $postData['id'];
            // obtendo mídia e diretório
            $media = FileDao::getNewObject($mediaPath);
            $directory = $media->getParent();
            // obtendo mídia anterior
            $mediaIndex = $directory->getMediaIndex($media);
            $previousMedia = $directory->getMedia($mediaIndex-1);
            // retornando informação
            if (!$previousMedia)
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else
                $response->setContent(\Zend\Json\Json::encode(array(
                    'response' => true, 'dataPath' => $previousMedia->getDataPath(),
                    'logicalPath' => $previousMedia->getLogicalPath(),
                )));
        }
        return $response;
    }



}

