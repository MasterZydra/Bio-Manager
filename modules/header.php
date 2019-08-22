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
                <button>Anmelden</button>
            </form>
            <?php
                }
            ?>
        </div>
    </header>
    <main>
