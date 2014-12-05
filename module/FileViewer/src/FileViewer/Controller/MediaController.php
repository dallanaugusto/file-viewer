<?php

namespace FileViewer\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use FileViewer\Model\Factory;

class MediaController extends AbstractActionController
{

    public function indexAction()
    {
        //$mediaPath = $this->params()->fromRoute('id', "");
        $mediaPath = isset($_REQUEST["id"])? $_REQUEST["id"]: null;
        $media = $mediaPath? Factory::getItem($mediaPath): null;
        if ($media) {
            $directory = $media->getParent();
            $links = $directory->getLinksFromLogicalPath();
            $parentLinks = $directory->getLinksFromLogicalPath();
            $medias = $directory->getMedias();
            $numMedias = sizeof($medias);
            foreach ($medias as $key => $media) {
                if ($media->getLogicalPath() == $mediaPath) {
                    $previousMediaId = $key -1;
                    $nextMediaId = $key + 1;
                    if ($previousMediaId == -1)
                        $previousMediaId = $numMedias - 1;
                    if ($nextMediaId == $numMedias)
                        $nextMediaId = 0;
                    $previousMedia = $medias[$previousMediaId];
                    $nextMedia = $medias[$nextMediaId];
                    break;
                }
            }
            
            $this->layout()->setVariable("pageTitle", $media->getName());
            $this->layout()->setVariable("mediaViewerIsOpen", true);
            return array(
                "media" => $media, "directory" => $directory, 
                "previousMedia" => $previousMedia, "nextMedia" => $nextMedia,
                "medias" => $medias, "parentLinks" => $parentLinks
            );
        }
        else
            return array("media" => null);
    }


}

