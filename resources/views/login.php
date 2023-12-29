<?= component('layout.header') ?>

<form action="login" method="post">
    <label for="user_login" class="required"><?= __('Username') ?>:</label><br>
    <input id="user_login" name="user_login" type="text" size="40" maxlength="250" required autofocus><br>
    
    <label for="user_password" class="required"><?= __('Password') ?>:</label><br>
    <input id="user_password" name="user_password" type="password" size="40"  maxlength="250" required><br>
    <button><?= __('Login') ?></button>
</form>

<?= component('layout.footer') ?>