<?php

use Framework\Authentication\Auth;
use Framework\Facades\Http;

// Redirect to home if user is already logged in
if (Auth::isLoggedIn()) {
    Http::redirect('/');
}

?>

<?= component('layout.header') ?>

<form action="login" method="post">
    <label for="username" class="required"><?= __('Username') ?>:</label><br>
    <input id="username" name="username" type="text" size="40" maxlength="250" required autofocus><br>
    
    <label for="password" class="required"><?= __('Password') ?>:</label><br>
    <input id="password" name="password" type="password" size="40"  maxlength="250" required><br>
    <button><?= __('Login') ?></button>
</form>

<?= component('layout.footer') ?>