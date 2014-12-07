<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Model\Factory;

class DirectoryController extends AbstractActionController
{

    public function indexAction()
    {
        // obtendo diretório
        $directoryPath = isset($_REQUEST["id"])? $_REQUEST["id"]: null;
        $directory = Factory::getItem($directoryPath);
        
        // formando caminho de links do diretório
        $logicalPathHtmlLinks = $directory->getAllLogicalPaths();
        
        // obtendo items filhos do diretório
        $items = $directory->getItems();
        
        // variáveis para view
        $this->layout()->setVariable("pageTitle", $directory->getLogicalPath());   
        return array(
            "directory" => $directory, "items" => $items, 
            "logicalPathHtmlLinks" => $logicalPathHtmlLinks,
        );
    }
    

}

