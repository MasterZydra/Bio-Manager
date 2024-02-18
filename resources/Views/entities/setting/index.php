<?php use Framework\Authentication\Auth; ?>
<?= component('layout.header') ?>

<h1><?= __('Setting') ?></h1>

<p>
    <?php if (Auth::hasRole('Developer')) { ?>
        <a href="setting/create"><?= __('AddSetting') ?></a>
    <?php } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Name') ?></th>
        <th class="center"><?= __('Description') ?></th>
        <th class="center"><?= __('Value') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Setting $setting */
    foreach ($settings as $setting): ?>
    <tr>
        <td><?= $setting->getName() ?></td>
        <td><?= $setting->getDescription() ?></td>
        <td><?= $setting->getValue() ?></td>
        <td><a href="setting/edit?id=<?= $setting->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>