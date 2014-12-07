<?php
$mediaViewerIsOpen = $this->media != null;
if ($mediaViewerIsOpen) {
    $mediaLink = $this->url("home").$media->getRelativePath();
    $previousMediaLink = $this->url("media")."?id=".$this->previousMedia->getLogicalPath();
    $nextMediaLink = $this->url("media")."?id=".$this->nextMedia->getLogicalPath();
}

$itemPath = "";
    foreach ($this->logicalPathHtmlLinks as $path => $name)
        $itemPath .= "/<a href=\"".$this->url("directory")."?id=".$path."\">".$name."</a>";
    
$hasNav = $this->directory->getLogicalPath();
if ($hasNav) {
    $directoryLink = $directory? 
        $this->url("directory")."?id=".$this->directory->getLogicalPath(): ".";
    $parentLink = $this->directory->getParent() && $this->directory->getParent()->getLogicalPath()?
        $this->url("directory")."?id=".$this->directory->getParent()->getLogicalPath(): ".";
    $firstMediaLink = $this->directory->hasMedia()? 
        $this->url("media")."?id=".$this->directory->getFirstMedia()->getLogicalPath(): null;
}
?>
            <div class="itemList">
<?php
if ($mediaViewerIsOpen) {
?>
                <div class="media">
                    <div class="picture">
                        <img src="<?php echo $mediaLink; ?>" alt="Mídia <?php echo $this->media->getName(); ?>">
                        <p class="caption"><?php echo $this->media->getName(); ?></p>
                    </div>
                    <ul class="nav">
                        <li class="previous">
                            <a href="<?php echo $previousMediaLink; ?>"><span>Anterior</span></a>
                        </li>
                        <li class="next">
                            <a href="<?php echo $nextMediaLink; ?>"><span>Posterior</span></a>
                        </li>
                    </ul>
                </div>
<?php
}
if ($hasNav) {
?>
                <nav>
<?php
    if ($this->directory->getParent()) {
?>                     
                    <li class="goback"><a href="<?php echo $parentLink; ?>">Voltar n&iacute;vel</a></li>
<?php
    }
    if ($mediaViewerIsOpen) {
?>                    
                    <li class="closeMediaViewer"><a href="<?php echo $directoryLink; ?>">Fechar visualizador</a></li>
<?php
    }
    if ($this->directory->hasMedia() && !$mediaViewerIsOpen) {
?>                    
                    <li class="openMediaViewer"><a href="<?php echo $firstMediaLink; ?>">Abrir visualizador</a></li>
<?php
    }
?>                                        
                </nav>
<?php
}
?>
                <h4 class="itemPath"><?php echo $itemPath; ?></h4>
<?php
if ($this->items) {
?>
                <ul class="items">
<?php
    foreach ($this->items as $item) {
        $itemLink = $this->url("home").$item->getUrl();
?>
                    <li class="<?php echo $item->getType(); ?>File">
                         <a href="<?php echo $itemLink; ?>"><?php echo $item->getShortLabel(); ?></a>
                    </li>
<?php                    
    } // foreach ($items as $item)
?>
                </ul>
<?php
}
?>
            </div>