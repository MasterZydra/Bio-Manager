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

    <label for="street" class="required"><?= __('Street') ?>:</label><br>
    <input id="street" name="street" type="text" value="<?= $recipient->getStreet() ?>" required><br>

    <label for="postalCode" class="required"><?= __('PostalCode') ?>:</label><br>
    <input id="postalCode" name="postalCode" type="text" value="<?= $recipient->getPostalCode() ?>" required><br>

    <label for="city" class="required"><?= __('City') ?>:</label><br>
    <input id="city" name="city" type="text" value="<?= $recipient->getCity() ?>" required><br>

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