<?php
include "constants.php";
?>
.itemList ul {
    list-style-type: none;
}

.itemList>.itemPath {
    border-bottom: 1px dashed <?php echo $defaultMediumColor; ?>;
    color: <?php echo $defaultMediumColor; ?>;
    font-size: 1.2em;
    padding: .2em 1em;
    text-align: left;
}

.itemList>.itemPath a {
    border: 0px solid <?php echo $defaultMediumColor; ?>;
    border-radius: 5px;
    color: <?php echo $defaultMediumColor; ?>;
    display: inline-block;
    margin: 0 .5em;
    padding: 1.5em .5em;
}

.itemList>.itemPath a:hover {
    background-color: <?php echo $defaultLightHoverColor; ?>;
}

.itemList>nav {
    border-bottom: 1px dashed <?php echo $defaultMediumColor; ?>;
}

.itemList>nav li, .itemList>.items li {
    display: inline-block;
    margin: .5%;
    vertical-align: top;
    max-width: 18.5%;
}

.itemList>nav li a, .itemList>.items li.notThumb a {
    background-position: 5px 1.3em;
    background-repeat: no-repeat;
    border: 0px solid <?php echo $defaultDarkColor; ?>;
    border-radius: 5px;
    color: <?php echo $defaultDarkColor; ?>;
    display: block;
    padding: 1.5em .5em;
    padding-left: 45px;
    word-wrap: break-word;
}

.itemList>nav li a:hover, .itemList>.items li a:hover {
    background-color: <?php echo $defaultLightHoverColor; ?>;
}

.itemList>.items li.thumb figure {
    padding: .5em;
    text-align: center;
}

.itemList>.items li.thumb.current figure {
    background: <?php echo $defaultLightHoverColor; ?>;
    border: 0px solid <?php echo $defaultLightHoverColor; ?>;
    border-radius: 5px;
}

.itemList>.items li.thumb figure img {
    max-width: 90%;
}

.itemList>.items li.thumb figure figcaption {
    font-size: .8em;
    word-wrap: break-word;
}

.itemList>nav li.home a {
    background-image: url(ico/home_ico.png);    
}

.itemList>nav li.goback a {
    background-image: url(ico/goback_ico.png);    
}

.itemList>nav li.openMediaViewer a {
    background-image: url(ico/mediaViewer_ico.png);    
}

.itemList>nav li.closeMediaViewer a {
    background-image: url(ico/error_ico.png);    
}

.itemList>.items li.notThumb.compactedFile a {
    background-image: url(ico/compacted_ico.png);    
}

.itemList>.items li.notThumb.directoryFile a {
    background-image: url(ico/directory_ico.png);    
}

.itemList>.items li.notThumb.documentFile a {
    background-image: url(ico/document_ico.png);    
}

.itemList>.items li.notThumb.executableFile a {
    background-image: url(ico/executable_ico.png);    
}

.itemList>.items li.notThumb.imageFile a {
    background-image: url(ico/image_ico.png);    
}

.itemList>.items li.notThumb.pdfFile a {
    background-image: url(ico/pdf_ico.png);    
}

.itemList>.items li.notThumb.presentationFile a {
    background-image: url(ico/presentation_ico.png);    
}

.itemList>.items li.notThumb.sheetFile a {
    background-image: url(ico/sheet_ico.png);    
}

.itemList>.items li.notThumb.textFile a {
    background-image: url(ico/text_ico.png);    
}

.itemList>.items li.notThumb.videoFile a, .itemList>.items li.html5VideoFile a {
    background-image: url(ico/video_ico.png);    
}

.itemList>.items li.notThumb.unknownFile a {
    background-image: url(ico/unknown_ico.png);    
}
