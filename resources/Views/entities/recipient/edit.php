<?php /** @var \App\Models\Recipient $recipient */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditRecipient') ?></h1>

<p>
    <a href="/recipient"><?= __('ShowAllRecipients') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $recipient->getId() ?>">

    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" maxlength="100" value="<?= $recipient->getName() ?>" required autofocus><br>

    <label for="address" class="required"><?= __('Address') ?>:</label><br>
    <textarea id="address" name="address" required><?= $recipient->getAddress() ?></textarea><br>

    <label>
        <input type="hidden" name="isLocked" value="0">
        <input type="checkbox" name="isLocked" value="1"
            <?php
            if ($recipient->getIsLocked()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsLocked') ?>
    </label><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $recipient->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>