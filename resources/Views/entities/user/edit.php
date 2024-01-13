<?php
    use \App\Models\Role;
    use Framework\Authentication\Auth;

    /** @var \App\Models\User $user */
?>
<?= component('layout.header') ?>

<h1><?= __('EditUser') ?></h1>

<p>
    <a href="/user"><?= __('ShowAllUsers') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $user->getId() ?>">

    <label for="firstname" class="required"><?= __('Firstname') ?>:</label><br>
    <input id="firstname" name="firstname" type="text" maxlength="30" value="<?= $user->getFirstname() ?>" required autofocus><br>

    <label for="lastname" class="required"><?= __('Lastname') ?>:</label><br>
    <input id="lastname" name="lastname" type="text" maxlength="30" value="<?= $user->getLastname() ?>" required><br>

    <label for="username" class="required"><?= __('Username') ?>:</label><br>
    <input id="username" name="username" type="text" maxlength="30" value="<?= $user->getUsername() ?>" required><br>

    <label for="password"><?= __('Password') ?>:</label><br>
    <input id="password" name="password" type="password" value=""><br>

    <label>
        <input type="hidden" name="isLocked" value="0">
        <input type="checkbox" name="isLocked" value="1"
            <?php
            if ($user->getIsLocked()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsLocked') ?>
    </label><br>

    <label>
        <input type="hidden" name="isPwdChangeForced" value="0">
        <input type="checkbox" name="isPwdChangeForced" value="1"
            <?php
            if ($user->getIsPwdChangeForced()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsPasswordChangeForced') ?>
    </label><br><br>

    <strong><?= __('Permissions') ?></strong><br>

    <?php /** @var \App\Models\Role $role */
    foreach (Role::all() as $role) { ?>
        <label>
            <input type="hidden" name="<?= $role->getName() ?>" value="0">
            <input type="checkbox" name="<?= $role->getName() ?>" value="1"
                <?php
                if (Auth::userHasRole($user->getId(), $role->getName())) {
                    echo ' checked';
                }
                ?>>
            <?= __($role->getName()) ?>
        </label><br>
    <?php } ?><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $user->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>