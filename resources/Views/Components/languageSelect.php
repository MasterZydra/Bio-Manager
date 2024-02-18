<?php
    use App\Models\Language;
    // Optional passed variables:
    //  $selected => Id that should be selected
?>
<label for="language"><?= __('Language') ?>:</label><br>
<select id="language" name="language">
    <option value=""><?= __('PleaseSelect') ?></option>
    <?php /** @var \App\Models\Language $language */
    foreach (Language::all() as $language) { ?> 
        <option value="<?= $language->getId() ?>" <?php
            if (isset($selected) && $language->getId() === $selected) { ?>selected<?php } ?>
        ><?= __($language->getName()) ?></option>
    <?php } ?>
</select>