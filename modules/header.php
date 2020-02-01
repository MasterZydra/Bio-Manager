<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bioStyle.css">
        <link rel="icon" href="img/apple.png">
        <title>Bio-Manager</title>
    </head>
    <body>
    <header>
        <?php
            // Build string for organisation in header
            $organisation = "";
            // Check if file exists to prevent warnings
            if (file_exists('config/CommonConfig.php')) {
                include_once 'config/CommonConfig.php';
                $organisation .= " - " . $common['organisation'];
            }
        ?>
        <h1>Bio-Manager <?php echo $organisation; ?></h1>
        <div>
            <a href="index.php">Startseite</a>
        </div>
        <?php
                if(!isset($_SESSION['userId'])) {
        ?>
        <div>
            <button onclick="window.location.href='login.php'">Anmelden</button>
        </div>
        <?php
            }
        ?>
    </header>
    <main <?php if (basename($_SERVER['PHP_SELF']) === "index.php") { echo 'class="inlineblock"'; } ?>>
