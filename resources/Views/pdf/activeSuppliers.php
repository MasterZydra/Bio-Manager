<?php use App\Models\Supplier; ?>
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
<tr>
    <td width="100%">
        <h1 style="text-align: center;">Aktive Lieferanten</h1>
        <p>
            <ul>
                <?php /** @var \App\Models\Supplier $supplier */
                foreach (Supplier::all() as $supplier) {
                    if ($supplier->getIsLocked()) continue;
                ?>
                    <li><?= $supplier->getName() ?></li>
                <?php } ?>
            </ul>
        </p>
        <p>Stand: <?= date("d.m.Y") ?></p>
    </td>
</tr> 
</table>