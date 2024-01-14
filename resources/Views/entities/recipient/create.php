<?= component('layout.header') ?>

<h1><?= __('AddRecipient') ?></h1>

<p>
    <a href="/recipient"><?= __('ShowAllRecipients') ?></a>    
</p>

<form action="store" method="post">
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" maxlength="100" required autofocus><br>

    <label for="address" class="required"><?= __('Address') ?>:</label><br>
    <textarea id="address" name="address" required></textarea><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>