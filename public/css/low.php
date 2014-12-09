<?php
include "constants.php";
?>
body>header {
    background: url(<?php echo $defaultMobileLogo; ?>) no-repeat 5px 5px;
    text-align: center;
}

body>nav a {
    padding-bottom: .7em !important;
    padding-top: .7em !important;
}

.simpleForm input[type="text"], .simpleForm input[type="email"], 
.simpleForm input[type="password"], .simpleForm textarea, 
.simpleForm select, .simpleForm datalist {
    margin-bottom: 1em !important;
    margin-top: 1em !important;
    padding-bottom: .8em !important;
    padding-top: .8em !important;
}

.simpleTable tr a {
    padding-bottom: 1.2em !important;
    padding-top: 1.2em !important;
}

.itemList>nav li, .itemList>.items li {
    max-width: 31.5% !important;
}

.mediaViewerIsOpen>header, .mediaViewerIsOpen>footer {
    display: none;
}