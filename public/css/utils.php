<?php
include "constants.php";
?>
.message {
    background-position: 5px 1.3em;
    background-repeat: no-repeat;
    font-size: 1.2em;
    margin: 1em;
    padding: 1.5em .5em;
    padding-left: 45px;
    position: relative;
}

.error {
    background-image: url(ico/error_ico.png); 
}

.information {
    color: #468;
}

.question {
    color: #995;
}

.success {
    color: #8b3;   
}

.media {
    background: #222;
    position: relative;
}

.media figure {
    margin: 0 auto;
    padding-top: .5em;
    width: 90%;
}

.media figure img {
    border: 1px solid <?php echo $defaultDarkColor; ?>;
    display: block;
    margin: .5em auto;
    max-height: 90%;
    max-width: 85%;
    outline: 0;
}

.media video {
    margin: 0 auto;
    padding-top: .5em;
    border: 1px solid <?php echo $defaultDarkColor; ?>;
    display: block;
    margin: .5em auto;
    max-height: 90%;
    max-width: 85%;
    padding-bottom: .5em;
    outline: 0;
}

.media figcaption {
    color: <?php echo $defaultLightColor; ?>;
    font-weight: bold;
    padding: .5em;
    text-align: center;
}

.media .mediaNav {
    position: relative;
}

.media .pageNav {
    border-top: 1px dashed <?php echo $defaultLightColor; ?>;
    padding: .5em 0;
    text-align: center;
}

.media .mediaNav li {
    bottom: 200px;
    color: <?php echo $defaultLightColor; ?>;
    position: absolute;
    height: 44px;
    width: 44px;
}

.media .pageNav li {
    color: <?php echo $defaultLightColor; ?>;
    display: inline-block;
    margin: .5em 0;
}

.media .mediaNav li a {
    display: block;
    height: 100%;
    width: 100%;
    text-indent: 100%;
    white-space: nowrap;
    overflow: hidden;
}

.media .pageNav li a {
    color: <?php echo $defaultLightColor; ?>;
    padding: .5em;
}

.media .pageNav li.current a {
    background: <?php echo $defaultLightHoverColor; ?>;
    border: 0px solid <?php echo $defaultLightHoverColor; ?>;
    border-radius: 3px;
    color: <?php echo $defaultDarkColor; ?>;
    margin: .5em;
}

.media .mediaNav li.previous {
    left: 0;
}

.media .mediaNav li.next {
    right: 0;
}

.media .mediaNav li.previous a {
    background: url(ico/lightLeftArrow_ico.png) no-repeat left 1% top 48%;
}

.media .mediaNav li.next a {
    background: url(ico/lightRightArrow_ico.png) no-repeat right 1% top 48%;
}

.media .mediaNav li.previous a:hover {
    background-image: url(ico/darkLeftArrow_ico.png);
} 

.media .mediaNav li.next a:hover {
    background-image: url(ico/darkRightArrow_ico.png);
}

@media screen and (max-height: 479px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 240px !important;
    }
}

@media screen and (min-height: 480px) and (max-height: 639px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 320px !important;
    }
}

@media screen and (min-height: 640px) and (max-height: 799px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 480px !important;
    }
}

@media screen and (min-height: 800px) and (max-height: 959px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 640px !important;
    }
}

@media screen and (min-height: 960px) and (max-height: 1119px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 800px !important;
    }
}

@media screen and (min-height: 1120px) and (max-height: 1279px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 960px !important;
    }
}

@media screen and (min-height: 1280px) and (max-height: 1440px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 1120px !important;
    }
}

@media screen and (min-height: 1440px) and (max-height: 1600px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 1280px !important;
    }
}

@media screen and (min-height: 1600px) and (max-height: 1760px) {
    .mediaViewerIsOpen .media figure img, .mediaViewerIsOpen .media video {
        max-height: 1440px !important;
    }
}