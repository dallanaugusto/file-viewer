<?php
include "constants.php";
?>
.simpleForm fieldset {
    border-width: 0;
    margin: 1em;
    position: relative;
}

.simpleForm legend {
    border-bottom: 2px solid #ccc;
    display: block;
    font-size: 1.5em;
    font-weight: bold;
    padding-bottom: .5em;
    text-align: left;
    width: 100%;
}

.simpleForm fieldset ul {
    display: table;
    list-style-type: none;
}

.simpleForm ul li {
    display: table-row;
}

.simpleForm label {
    display: table-cell;
    margin: .5em 0;
    padding: .2em .5em;
    text-align: right;
    vertical-align: middle;
    width: 25%;
}

.simpleForm li .hint {
    color: #800;
    display: table-cell;
    font-style: italic;
    margin: .5em 0;
    padding: .2em;
    vertical-align: middle;
    width: 25%;
}

.simpleForm input[type="text"], .simpleForm input[type="email"], 
.simpleForm input[type="password"], .simpleForm textarea, 
.simpleForm select, .simpleForm datalist {
    background-color: #fff;
    border: 1px solid #d8d8d8;
    border-radius: 4px;
    display: table-cell;
    margin: .5em 0;
    padding: .2em;
    width: 90%;
}

.simpleForm li.invalid * {
    border-color: #d8b8b8;
    color: #800;
}

.simpleForm input[type="checkbox"] {
    background-color: #fff;
    border: 1px solid #d8d8d8;
    margin: .5em 0;
    vertical-align: middle;
}

.simpleForm input[type="submit"] {
    background-color: #fff;
    border: 1px solid #d8d8d8;
    border-radius: 4px;
    display: inline-block;
    margin-left: 100%;
    padding: .2em;
}

.simpleForm input[type="submit"]:hover {
    background-color: #d8d8d8;
}