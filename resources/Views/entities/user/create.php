<?php
    use App\Models\Role;
?>
<?= component('layout.header') ?>

<h1><?= __('AddUser') ?></h1>

<p>
    <a href="/user"><?= __('ShowAllUsers') ?></a>    
</p>

<form action="store" method="post">
    <label for="firstname" class="required"><?= __('Firstname') ?>:</label><br>
    <input id="firstname" name="firstname" type="text" maxlength="30" required autofocus><br>

    <label for="lastname" class="required"><?= __('Lastname') ?>:</label><br>
    <input id="lastname" name="lastname" type="text" maxlength="30" required><br>

    <label for="username" class="required"><?= __('Username') ?>:</label><br>
    <input id="username" name="username" type="text" maxlength="30" required><br>

    <label for="password" class="required"><?= __('Password') ?>:</label><br>
    <input id="password" name="password" type="password"><br>

    <label>
        <input type="hidden" name="isLocked" value="0">
        <input type="checkbox" name="isLocked" value="1">
        <?= __('IsLocked') ?>
    </label><br>

    <label>
        <input type="hidden" name="isPwdChangeForced" value="0">
        <input type="checkbox" name="isPwdChangeForced" value="1">
        <?= __('IsPasswordChangeForced') ?>
    </label><br><br>

    <strong><?= __('Permissions') ?></strong><br>

    <?php /** @var \App\Models\Role $role */
    foreach (Role::all() as $role) { ?>
        <label>
            <input type="hidden" name="<?= $role->getName() ?>" value="0">
            <input type="checkbox" name="<?= $role->getName() ?>" value="1">
            <?= __($role->getName()) ?>
        </label><br>
    <?php } ?><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>