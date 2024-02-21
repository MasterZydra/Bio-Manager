<?php

use Framework\Authentication\Auth;
use Framework\Message\Message;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bioStyle.css">
    <link rel="icon" href="/img/apple.png">
    <title>Bio-Manager</title>
</head>

<body>
    <header>
        <h1 style="cursor: pointer"><a href="/">Bio-Manager</a></h1>
        <div>
            <?php if (!Auth::isLoggedIn()) { ?>
                <button style="cursor: pointer" onclick="window.location.href='login'"><?= __('Login') ?></button>
            <?php } ?>
        </div>
    </header>

    <main>
        <?php
            foreach (Message::getMessages() as $message) {
                echo '<div class="message ' . lcfirst($message['type']->value) . '">' . $message['message'] . '</div>';
            }
        ?>
