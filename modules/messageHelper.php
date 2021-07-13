<?php
/*
* messageHelper.php
* -----------------
* This file contains helper function to show message boxes.
*
* @Author: David Hein
*/

function showBox(string $type, string $message) {
    echo '<div class="' . $type . '">' . $message . '</div>';
}

function showInfobox(string $message) {
    showBox('infobox', $message);
}

function showWarning(string $message) {
    showBox('warning', $message);
}

function showWarningWithUrl(
    string $message,
    string $url,
    string $urlName)
{
    showWarning(
        $message .
        '<br><a href="' . $url . '">' . $urlName . '</a>');
}

?>