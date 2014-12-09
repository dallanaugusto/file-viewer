<?php
include "constants.php";
?>
.simpleTable {
    margin: 1em;
    position: relative;
}

.simpleTable .new, .simpleTable .manyToManyLink {
    background: #eee;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: .3em;
}

.simpleTable table {
    border-collapse: collapse;
    text-align: left;
    width: 100%;
}

.simpleTable table caption {
    border-bottom: 2px solid #ccc;
    font-size: 1.5em;
    font-weight: bold;
    padding: .5em 0;
    text-align: left;
}

.simpleTable table th, .simpleTable table td a {
    padding: .5em;
}

.simpleTable table th {
    border-bottom: 2px solid #ccc;
}

.simpleTable table td {
    border-bottom: 1px solid #ccc;
}

.simpleTable table td ul {
    list-style-type: none;
}

.simpleTable table td a {
    display: block;
}

.simpleTable table td ul a {
    display: inline;
}

.simpleTable table tbody tr:hover {
    background: #e8e8e8;
}

.simpleTable form {
    position: absolute;
    right: 2em;
    top: .5em;
}

.simpleTable fieldset {
    border-width: 0;
}

.simpleTable fieldset ul {
    list-style-type: none;
}

.simpleTable form legend, .simpleTable form label {
    display: none;
}

.simpleTable form input[type=text] {
    border: 1px solid #d8d8d8;
    outline: 0;
}

.simpleTable form input[type=submit] {
    display: none;
}