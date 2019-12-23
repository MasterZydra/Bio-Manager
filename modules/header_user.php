<?php
/*
* header_user.php
* ---------------
* Include this page if only logged in users are allowed to see the page content.
* If the visitor is not logged in, the browser forwards to index.php
*
* @Author: David Hein
*/
    session_start();

    // If not logged in
    if(!isset($_SESSION['userId'])) {
        header("Location: index.php");
        exit();
    }
?>