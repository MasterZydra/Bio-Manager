<?= component('layout.header') ?>

<h1>Systeminformationen</h1>

<table>
    <tr>
        <td>Bio-Manager Version</td>
        <td class="right">1.3.10</td>
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