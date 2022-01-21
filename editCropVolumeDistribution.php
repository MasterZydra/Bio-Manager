<?php
/*
* editCropVolumeDistribution.php
* ---------------
* This form is used to manage the distribution of a delivery note
* to multiple plots.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (
    !isMaintainer() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: deliveryNote.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/selectBox_BioManager.php';

// Add "\" to every "<" and "/" to avoid HTML validator warnings
function formatSelectBox($code)
{
    $code = addslashes($code);
    $code = str_replace("<", "\<", $code);
    $code = str_replace("/", "\/", $code);
    return $code;
}

?>
<h1>Mengenverteilung</h1>

<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>

<?php
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde kein Lieferschein übergeben. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
    echo '</div>';
} else {
    // Update the volume distribution
    if (isset($_GET['update'])) {
        $conn = new \System\Modules\Database\MySQL\MySql();
        $conn -> dbConnect();

        $i = 1;
        // Delete volume distribution for current delivery note
        $conn -> freeRun('DELETE FROM T_CropVolumeDistribution WHERE deliveryNoteId = ' . secGET('id'));
        // Add volume distribution for current delivery note
        while (true) {
            $isValid = true;

            // Insert until POST variable is not set
            if (!isset($_POST['plot' . (string)$i])) {
                break;
            }

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $deliveryNoteId = [
                "type" => "int",
                "val" => secGET('id')
            ];

            $plotId = [
                "type" => "int",
                "val" => secPOST('plot' . (string)$i)
            ];

            // Input validation
            $isValid &= is_numeric(secPOST('amount' . (string)$i));

            $amount = [
                "type" => "int",
                "val" => secPOST('amount' . (string)$i)
            ];

            $i++;

            if (!$isValid) {
                continue;
            }

            $data = array($NULL, $deliveryNoteId, $plotId, $amount);
            $conn -> insertInto('T_CropVolumeDistribution', $data);
        }
        $conn -> dbDisconnect();
        $conn = null;
    }

    $conn = new \System\Modules\Database\MySQL\MySql();
    $conn -> dbConnect();
    // Select amount from delivery note
    $conn -> select('T_DeliveryNote', 'year, nr, amount', 'id = ' . secGET('id'));
    $delivery = $conn -> getFirstRow();
    // Distribution data
    $distData = $conn -> select('T_CropVolumeDistribution', '*', 'deliveryNoteId = ' . secGET('id'));

    $conn -> dbDisconnect();
    $conn = null;

    if ($distData -> num_rows > 0) {
        $i = 1;
        $tableData = '';
        while ($row = $distData->fetch_assoc()) {
            $tableData .= '<tr>';
            $tableData .= '<td>' . plotSelectBox('plot' . (string)$i, $row['plotId']) . '</td>';
            $tableData .= '<td><input name="amount' . (string)$i
                . '" class="right" type="number" onkeyup="sumDistribution()" value="'
                . $row['amount'] . '" required></td>';
            $tableData .= '</tr>';
            $i++;
        }
    }
    ?>

<form action="?id=<?php echo secGET('id'); ?>&update=1" method="post">
    <table id="delivery" class="completeWidth">
        <tr>
            <th width="70%" class="center">Gesamte Liefermenge von Lieferschein <strong>
                <?php echo $delivery['year'] . ' ' . $delivery['nr']; ?>
            </strong></th>
            <th width="30%" class="right"><?php echo $delivery['amount']; ?></th>
        </tr>
    </table>
    <table id="distribution" class="completeWidth">
        <tr>
            <th width="70%" class="center">Flurstück</th>
            <th width="30%" class="center">Menge</th>
        </tr>
    <?php if (isset($tableData)) {
        echo $tableData;
    } ?>
    </table>
    <table class="completeWidth">
        <tr>
            <th width="70%" class="center">Summe über die Flurstücke</th>
            <th width="30%" class="right" id="distSum"></th>
        </tr>
    </table>
    <button>Übernehmen</button>
</form>
<button onclick="addRow('distribution')">Flurstück hinzufügen</button>
<button onclick="deleteRow('distribution')">Flurstück entfernen</button>

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
    
    // Get a HTML element from html code
    function htmlToElement(html) {
        var template = document.createElement('template');
        html = html.trim();
        template.innerHTML = html;
        return template.content.firstChild;
    }
    
    // Add a new row with select and input element
    function addRow(tableID) {
        var selectBox = "\<td><?php echo formatSelectBox(plotSelectBox()); ?>\<\/td>";
        var numInput = "\<td>\<input name=\"amount" + tableRef.rows.length.toString() +
            "\" class=\"right\" type=\"number\" onkeyup=\"sumDistribution()\" required>\<\/td>";
        // Replace element name
        var row = htmlToElement(selectBox);
        row.getElementsByTagName("select")[0].setAttribute("name", "plot" + tableRef.rows.length.toString());
        // Insert row
        var newRow   = tableRef.insertRow(tableRef.rows.length);
        newRow.innerHTML = row.outerHTML + numInput;
    }
    
    // Delete a row in a table
    function deleteRow(tableId) {
        var tableRef = document.getElementById(tableId);
        tableRef.deleteRow(tableRef.rows.length - 1);
    }
    
    // Add empty row if no data in data base
    if (tableRef.rows.length == 1) addRow('distribution');
    // Calc sum
    sumDistribution();
</script>
    <?php
}
    include 'Modules/footer.php';
?>