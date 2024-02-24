<?= component('layout.header') ?>

<h1>Systeminformationen</h1>

<table class="scrollable">
    <tr>
        <td>Bio-Manager Version</td>
        <td class="right">2.1.0</td>
    </tr>
    <tr>
        <td><?= __('Developer') ?></td>
        <td class="right">David Hein</td>
    </tr>
    <tr>
        <td>PHP Version</td>
        <td class="right"><?php echo phpversion(); ?></td>
    </tr>
</table>

<?= component('layout.footer') ?>