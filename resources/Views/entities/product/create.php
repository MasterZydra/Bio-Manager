<?= component('layout.header') ?>

<h1><?= __('AddProduct') ?></h1>

<p>
    <a href="/product"><?= __('ShowAllProducts') ?></a>    
</p>

<form action="store" method="post">
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" size="40" maxlength="50" required autofocus><br>
    
    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>