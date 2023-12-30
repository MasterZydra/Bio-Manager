<?= component('layout.header') ?>

<h1><?= __('User') ?></h1>

<?php /** @var \App\Models\User $user */
foreach ($users as $user): ?>
    <?= $user->getId() ?> - <?= $user->getFirstname() ?> - <?= $user->getLastname() ?> - <?= $user->getUsername() ?> - <?= $user->getPassword() ?> - <?= $user->getIsLocked() ? 'true' : 'false' ?> - <?= $user->getIsPwdChangeForced() ? 'true' : 'false' ?>
    <a href="user/show?id=<?= $user->getId() ?>">Details</a>
    <a href="user/edit?id=<?= $user->getId() ?>">Edit</a>
    <?= $user->getCreatedAt() ?> - <?= $user->getUpdatedAt() ?>
    <br>
<?php endforeach ?>

<button style="cursor: pointer" onclick="window.location.href='user/create'"><?= __('CreateNewUser') ?></button>

<?= component('layout.footer') ?>