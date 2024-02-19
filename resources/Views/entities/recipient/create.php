<?= component('layout.header') ?>

<h1><?= __('AddRecipient') ?></h1>

<p>
    <a href="/recipient"><?= __('ShowAllRecipients') ?></a>    
</p>

<form action="store" method="post">
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" maxlength="100" required autofocus><br>

    <label for="street" class="required"><?= __('Street') ?>:</label><br>
    <input id="street" name="street"  type="text" required></input><br>

    <label for="postalCode" class="required"><?= __('PostalCode') ?>:</label><br>
    <input id="postalCode" name="postalCode"  type="text"  required></input><br>

    <label for="city" class="required"><?= __('City') ?>:</label><br>
    <input id="city" name="city" type="text" required></input><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>