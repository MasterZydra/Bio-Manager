<?php
    session_start();

    // If not logged in
    if(!isset($_SESSION['userId'])) {
        header("Location: index.php");
        exit();
    }
?>