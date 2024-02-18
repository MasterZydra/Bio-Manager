<?= component('layout.header') ?>

<h1><?= __('AddSetting') ?></h1>

<p>
    <a href="/setting"><?= __('ShowAllSettings') ?></a>    
</p>

<form action="store" method="post">
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" size="100" maxlength="100" required autofocus><br>

    <label for="description" class="required"><?= __('Description') ?>:</label><br>
    <input id="description" name="description" type="text" size="255" maxlength="255" required><br>

    <label for="value" class="required"><?= __('Value') ?>:</label><br>
    <input id="value" name="value" type="text" size="255" maxlength="255" required><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>