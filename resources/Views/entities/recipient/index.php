<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Recipient') ?></h1>

<p>
    <a href="recipient/create"><?= __('AddRecipient') ?></a>
</p>

<?= component('filterInput') ?>

<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Name') ?></th>
        <th class="center"><?= __('Address') ?></th>
        <th class="center"><?= __('IsLocked') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Recipient $recipient */
    foreach ($recipients as $recipient): ?>
    <tr>
        <td><?= $recipient->getName() ?></td>
        <td class="center"><?= mb_strimwidth($recipient->getStreet() . ' ' . $recipient->getPostalCode() . ' ' . $recipient->getCity(), 0, 50, '...') ?></td>
        <td class="center"><?= Convert::boolToTString($recipient->getIsLocked()) ?></td>
        <td><a href="recipient/edit?id=<?= $recipient->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>