<?php
    /** @var \App\Models\DeliveryNote $deliveryNote */
    /** @var array $distributions */
?>
<?= component('layout.header') ?>

<h1><?= __('VolumeDistribution') ?></h1>

<p>
    <a href="/deliveryNote"><?= __('ShowAllDeliveryNotes') ?></a>    
</p>

<form method="post">
    <input name="id" type="hidden" value="<?= $deliveryNote->getId() ?>">

    <table id="delivery" class="completeWidth">
        <tr>
            <th width="70%" class="center">Gesamte Liefermenge von Lieferschein <strong>
                <?= $deliveryNote->getYear() . ' ' . $deliveryNote->getNr() ?>
            </strong></th>
            <th width="30%" class="right"><?= $deliveryNote->getAmount() ?></th>
        </tr>
    </table>
    <table id="distribution" class="completeWidth">
        <tr>
            <th width="70%" class="center">Flurstück</th>
            <th width="30%" class="center">Menge</th>
        </tr>
        <?php
            $index = 0;
            /** @var \App\Models\VolumeDistribution $distribution */
            foreach ($distributions as $distribution) {
        ?>
            <tr>
                <td><?= component('plotSelect', ['index' => $index, 'selected' => $distribution->getPlotId()]) ?></td>
                <td>
                    <input name="amount[<?= $index ?>]" class="right" type="number" onkeyup="sumDistribution()"
                        value="<?= $distribution->getAmount() ?>" required
                    >
                </td>
            </tr>
        <?php $index++; } ?>
    </table>
    <table class="completeWidth">
        <tr>
            <th width="70%" class="center">Summe über die Flurstücke</th>
            <th width="30%" class="right" id="distSum"></th>
        </tr>
    </table>

    <button><?= __('Save') ?></button>
</form>

<button onclick="addRow('distribution')">Flurstück hinzufügen</button>
<button onclick="deleteRow('distribution')">Flurstück entfernen</button>

<div id="template" hidden>
    <?= component('plotSelect', ['index' => '<index>']) ?>
    <input name="amount[<index>]" class="right" type="number" onkeyup="sumDistribution()" required>
</div>

<script>
    var tableRef = document.getElementById('distribution');
    var sumRef = document.getElementById("distSum");
    var deliveryAmount = parseInt(document.getElementById("delivery").rows[0].cells[1].innerHTML);
    
    // Sum all amounts from plots
    function sumDistribution() {
        var sumtbl = 0;
        // Sum all rows
        for(var i = 1; i < tableRef.rows.length; i++) {
            strVal = tableRef.rows[i].cells[1].getElementsByTagName("input")[0].value
            // Prevent NaN
            if(strVal == "") {
                strVal = "0"
            }
            sumtbl += parseInt(strVal);
        }
        
        // Write sum into cell
        sumRef.innerHTML = sumtbl;
        // Color cell red if sum is greater then delivery amount
        sumRef.classList.remove('red');
        sumRef.classList.remove('grey');
        if(deliveryAmount < sumtbl) {
            sumRef.classList.add('red');
        } else if(deliveryAmount > sumtbl) {
            sumRef.classList.add('grey');
        }
    }

    // Add a new row with select and input element
    function addRow(tableID) {
        var elem = document.getElementById("template");
        var row = elem.cloneNode(true);
        // Replace element name
        row.getElementsByTagName("select")[0].setAttribute("name", "plot[" + (tableRef.rows.length - 1).toString() + "]");
        row.getElementsByTagName("input")[0].setAttribute("name", "amount[" + (tableRef.rows.length - 1).toString() + "]");
        row.removeAttribute("id");
        // Insert row
        var newRow = tableRef.insertRow(tableRef.rows.length);
        newRow.insertCell().insertAdjacentElement("beforeend", row.getElementsByTagName("select")[0]);
        newRow.insertCell().insertAdjacentElement("beforeend", row.getElementsByTagName("input")[0]);
    }

    // Delete a row in a table
    function deleteRow(tableId) {
        var tableRef = document.getElementById(tableId);
        tableRef.deleteRow(tableRef.rows.length - 1);
        sumDistribution();
    }
    
    // Add empty row if no data in data base
    if (tableRef.rows.length == 1) addRow('distribution');
    // Calc sum
    sumDistribution();
</script>

<?= component('layout.footer') ?>
