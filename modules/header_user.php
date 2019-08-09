<?php
    session_start();

    // If not logged in
    if(!isset($_SESSION['userId'])) {
        header("Location: index.php");
        exit();
    }

    // Show PHP messages and warnings if user is developer
    if($_SESSION['isDeveloper']) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
?>