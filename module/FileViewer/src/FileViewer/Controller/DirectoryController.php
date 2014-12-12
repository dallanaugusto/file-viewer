<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Model\DirectoryDao;

class DirectoryController extends AbstractActionController
{

    public function indexAction()
    {
        // obtendo caminho do diretório
        $directoryPath = isset($_REQUEST["id"])? $_REQUEST["id"]: null;
        
        // obtendo diretório
        $directory = DirectoryDao::getNewObject($directoryPath);
        
        // formando caminho de links do diretório
        $allLogicalPaths = $directory->getAllLogicalPaths();
        
        // obtendo items filhos do diretório
        $items = $directory->getItems();
        
        // variáveis para view
        $this->layout()->setVariable("pageTitle", $directory->getLogicalPath());   
        return array(
            "directory" => $directory, "items" => $items, 
            "allLogicalPaths" => $allLogicalPaths,
        );
    }
    

}

