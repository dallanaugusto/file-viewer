<?php
include "constants.php";
?>
.interactiveNav {
    background-color: rgba(63,63,63,0.9);
    border-radius: 5px;   
    box-shadow: 0 10px 12px -6px rgba(000, 000, 000, 0.4), inset 0 0 0 5px rgba(255, 255, 255, 0.1);
    padding: .3em;
}

.interactiveNav a, .interactiveNav a:visited {
    color: #f8f8f8;
}

.interactiveNav a:hover {
    background: rgba(0,0,0,0.9);
}

.interactiveNav ul {
    list-style-type: none;
}

.interactiveNav>h2 {
    font-size: 1.5em;
    padding: .5em;
}

.interactiveNav:hover>h2 {
    display: none;
}

.interactiveNav>ul {
    display: none;
}

.interactiveNav:hover>ul {
    display: block;
}

.interactiveNav>ul>li {
    display: inline-table;
    vertical-align: top;
}

.interactiveNav>ul>li>h3 {
    color: #f8f8f8;
}

.interactiveNav>ul>li>h3, .interactiveNav>ul>li>ul>li>a  {
    display: block;
    padding: .5em;
}


/*
.dropDownNav {
    //width: auto;
}

.dropDownNav, .dropDownNav ul {
    //list-style: none;
}

.dropDownNav, .dropDownNav li ul {
    //background-color: rgba(0,0,0,0.9);
    ///border: 1px solid #888;
    //border-radius: 7px;
    //color: #f8f8f8;
    //text-align: right;
}

.dropDownNav a, .dropDownNav a:visited {
    //color: #f8f8f8;
    //display: block;
    //font-size: .8em;
    //padding: .3em;
    //margin: 0 .5em;
}

.dropDownNav li a {
    //border-top: 1px solid #888;
}

.dropDownNav ul>li:first-child>a {
    //border-top-width: 0;
}

.dropDownNav a:hover {
    //background-color: rgba(0,0,0,0.9);
    //text-shadow: 0px 0px 5px #999;    
}

.dropDownNav ul {
    //display: none;
}

.dropDownNav:hover>ul {
    //display: block;
    //width: 10em;
}

.dropDownNav li:hover, .dropDownNav a:hover {
    //color: #f8f8f8;
}

.dropDownNav li:hover>ul {
    //display: block;
    //width: 12em;
}

.dropDownNav li {
    //position: relative;
}

.dropDownNav li ul {
    //right: 4em;
    //position: absolute;
    //top: .7em;
    //z-index: 4;
}

*/
