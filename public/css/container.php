<?php
include "constants.php";
?>
body {
    background-color: <?php echo $defaultLightColor; ?>;
    color: <?php echo $defaultDarkColor; ?>;
    font-family: <?php echo $defaultTextFamily; ?>;
}

body>header {
    padding-top: .4em;
}

body>header>.unespHeadings {
    display: none;
}

body>header>.applicationHeadings, body>header>.organizationHeadings {
    font-size: .8em;
}

body>header>.pageHeadings {
    background: <?php echo $defaultDarkColor; ?>;
    color: <?php echo $defaultLightColor; ?>;
    font-size: 1.2em;
    margin-top: .4em;
    padding: .5em 0;
    text-align: center;
}

body>nav {
    position: fixed;
    right: .3em;
    top: .3em;
    z-index: 3;
}

body>nav>ul>li {
    font-size: .8em;
}

#main {
    position: relative;
}

body>footer {
    position: relative;
}

body>footer>address {
    border-top: 1px dashed <?php echo $defaultDarkColor; ?>;
    font-style: normal;
    font-weight: bold;
    text-align: center;
    padding: .5em 0;
}

#validators {
    position: absolute;
    right: .5em;
    top: .5em;
}