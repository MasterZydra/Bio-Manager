<?= component('layout.header') ?>

<h1><?= __('ChangePassword') ?></h1>

<form action="changePassword" method="post">
    <label for="oldPassword" class="required"><?= __('OldPassword') ?>:</label><br>
    <input id="oldPassword" name="oldPassword" type="password" required autofocus><br>

    <label for="newPassword" class="required"><?= __('NewPassword') ?>:</label><br>
    <input id="newPassword" name="newPassword" type="password" required><br>
    
    <label for="confirmedPassword" class="required"><?= __('RepeatNewPassword') ?>:</label><br>
    <input id="confirmedPassword" name="confirmedPassword" type="password" required><br>

    <button><?= __('ChangePassword') ?></button>
</form>

<?= component('layout.footer') ?>
