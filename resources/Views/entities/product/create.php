<?= component('layout.header') ?>

<form action="store" method="post">
    <label for="name" class="required"><?= __('ProductName') ?>:</label><br>
    <input id="name" name="name" type="text" size="40" maxlength="50" required autofocus><br>
    
    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>