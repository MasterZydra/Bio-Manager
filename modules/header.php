<?php
    // Show PHP messages and warnings if user is developer
    if($_SESSION['isDeveloper']) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bioStyle.css">
        <title>Bio-Manager</title>
    </head>
    <body>
    <header>
        <h1>Bio-Manager des OGV Eichelsbach e.V.</h1>
        <div>
            <a href="index.php">Startseite</a>
        </div>
        <div>
            <?php
                if(!isset($_SESSION['userId'])) {
            ?>
            <form action="login.php">
                <input type="submit" value="Anmelden"/>
            </form>
            <?php
                }
                else {
            ?>
            <form action="logout.php">
                <input type="submit" value="Abmelden" />
            </form>
            <?php
                }
            ?>
        </div>
    </header>
    <main>
