<?= component('layout.header') ?>

<h1><?= __('User') ?></h1>

<?php /** @var \App\Models\User $user */ ?>
Id: <?= $user->getId() ?><br>
Firstname: <?= $user->getFirstname() ?><br>
Lastname: <?= $user->getLastname() ?><br>
Username: <?= $user->getUsername() ?><br>
Password: <?= $user->getPassword() ?><br>
IsLocked: <?= $user->getIsLocked() ? 'true' : 'false' ?><br>
IsPwdChangeForced: <?= $user->getIsPwdChangeForced() ? 'true' : 'false' ?><br>

<?= component('layout.footer') ?>
