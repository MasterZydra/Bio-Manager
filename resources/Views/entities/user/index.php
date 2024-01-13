<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('User') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="user/create"><?= __('AddUser') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable">
    <tr>
        <th class="center"><?= __('Firstname') ?></th>
        <th class="center"><?= __('Lastname') ?></th>
        <th class="center"><?= __('Username') ?></th>
        <th class="center"><?= __('IsLocked') ?></th>
        <th class="center"><?= __('IsPasswordChangeForced') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\User $user */
    foreach ($users as $user): ?>
    <tr>
        <td><?= $user->getFirstname() ?></td>
        <td><?= $user->getLastname() ?></td>
        <td><?= $user->getUsername() ?></td>
        <td class="center"><?= Convert::boolToTString($user->getIsLocked()) ?></td>
        <td class="center"><?= Convert::boolToTString($user->getIsPwdChangeForced()) ?></td>
        <td><a href="user/edit?id=<?= $user->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>