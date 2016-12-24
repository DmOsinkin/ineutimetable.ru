<?php

include 'functions.php';

echo '<html>';

include 'head.php';
include 'header.php';

echo '<body>';

if ($_GET != null) {
    switch ($_GET["page"]) {
        case 'timetable':
            include 'homepage.php';
            header("location: timetable.php?group=" . $_GET["group"]);
            break;
        default:
            echo "<h1>404 =(</h1>";
            break;
    }
} else {
    include 'homepage.php';
}
echo '</body>';
echo '</html>';
