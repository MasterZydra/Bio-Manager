<?php
    use App\Models\Recipient;
    // Optional passed variables:
    //  $selected => Id that should be selected
?>
<label for="recipient" class="required"><?= __('Recipient') ?>:</label><br>
<select id="recipient" name="recipient">
    <?php /** @var \App\Models\Recipient $recipient */
    foreach (Recipient::all() as $recipient) { 
        if ($recipient->getIsLocked()) { continue; } ?>
        <option value="<?= $recipient->getId() ?>" <?php
            if (isset($selected) && $recipient->getId() === $selected) { ?>selected<?php } ?>
        ><?= $recipient->getName() ?></option>
    <?php } ?>
</select>