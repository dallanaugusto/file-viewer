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
        $mediaPath = \filter_input(\INPUT_GET,"path");
        $directoryPath = \filter_input(\INPUT_GET,"directory");
        $mediaId = \filter_input(\INPUT_GET,"id");
        $pageSize = Configuration::get("custom", "pageSize");
        
        if ($mediaPath) {
            // obtendo mídia        
            $media = FileDao::getNewObject($mediaPath);        
            // obtendo diretório
            $directory = $media->getParent();
            // índice da mídia atual no diretório
            $currentMediaIndex = $directory->getMediaIndex($media);
        }
        else if ($directoryPath) { 
            // obtendo diretório
            $directory = DirectoryDao::getNewObject($directoryPath);
            // obtendo mídia   
            if ($mediaId) {
                $media = $directory->getMedia($mediaId);
                // índice da mídia atual no diretório
                $currentMediaIndex = $mediaId;
            }
            else {                
                $media = $directory->getFirstMedia();
                // índice da mídia atual no diretório
                $currentMediaIndex = 0;
            }
        }
        else
            throw new ItIsNotItemException("");
        
        // formando caminho de links do diretório
        $allLogicalPaths = $directory->getAllLogicalPaths();
        
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
    
    public function getPreviousMediaAction() 
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            // obter dados
            $postData = $request->getPost();
            $mediaPath = $postData['path'];
            // obtendo mídia e diretório
            $media = FileDao::getNewObject($mediaPath);
            $directory = $media->getParent();
            $numItems = sizeof($directory->getMedias());
            // obtendo mídia anterior
            $mediaIndex = $directory->getMediaIndex($media);
            $previousMediaIndex = $mediaIndex > 0?
                $mediaIndex - 1: $numItems - 1;
            $previousMedia = $directory->getMedia($previousMediaIndex);
            $previousMediaName = $previousMedia->getName();
            // obtendo items próximos ao item atual
            $items = $directory->getMediasByMediaIndex($previousMediaIndex);
            // verificando se há mudança de página
            $pageSize = Configuration::get("custom", "pageSize");            
            $otherPage = (int)($mediaIndex / $pageSize) != (int)($previousMediaIndex / $pageSize);
            // retornando informação
            if (!$previousMedia)
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else
                $response->setContent(\Zend\Json\Json::encode(array(
                    'response' => true, 'dataPath' => $previousMedia->getDataPath(),
                    'logicalPath' => $previousMedia->getLogicalPath(),
                    'id' => $previousMediaIndex, 'name' => $previousMediaName,
                    'numItems' => $numItems, 'otherPage' => $otherPage,
                )));
        }
        return $response;
    }
    
    public function getNextMediaAction() 
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            // obter dados
            $postData = $request->getPost();
            $mediaPath = $postData['path'];
            // obtendo mídia e diretório
            $media = FileDao::getNewObject($mediaPath);
            $directory = $media->getParent();
            $numItems = sizeof($directory->getMedias());
            // obtendo mídia posterior
            $mediaIndex = $directory->getMediaIndex($media);
            $nextMediaIndex = $mediaIndex < $numItems - 1?
                $mediaIndex + 1: 0;
            $nextMedia = $directory->getMedia($nextMediaIndex);
            $nextMediaName = $nextMedia->getName();
            // verificando se há mudança de página
            $pageSize = Configuration::get("custom", "pageSize");
            $otherPage = 
                (int)($mediaIndex / $pageSize) != (int)($nextMediaIndex / $pageSize);
            // retornando informação
            if (!$nextMedia)
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else
                $response->setContent(\Zend\Json\Json::encode(array(
                    'response' => true, 'dataPath' => $nextMedia->getDataPath(),
                    'logicalPath' => $nextMedia->getLogicalPath(),
                    'id' => $nextMediaIndex, 'name' => $nextMediaName,
                    'numItems' => $numItems, 'otherPage' => $otherPage,
                )));
        }
        return $response;
    }



}

