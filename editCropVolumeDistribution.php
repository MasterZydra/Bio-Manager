<?php
/*
* editDeliveryNote.php
* ---------------
* This form is used to manage the distribution of a delivery note
* to multiple plots.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isMaintainer()) {
        header("Location: cropVolumeDistribution.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';
?>
<h1>Mengenverteilung</h1>
<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>
<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferschein übergeben. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
        echo '</div>';
    } else {
        if(isset($_GET['update'])) {
            $conn = new Mysql();
            $conn -> dbConnect();
            
            $i = 1;
            $conn -> freeRun('DELETE FROM T_CropVolumeDistribution WHERE deliveryNoteId = ' . $_GET['id']);
            while (true) {
                if(!isset($_POST['plot' . (string)$i])) {
                    break;
                }

                $NULL = [
                    "type" => "null",
                    "val" => "null"
                ];
                
                $deliveryNoteId = [
                    "type" => "int",
                    "val" => $_GET['id']
                ];
                
                $plotId = [
                    "type" => "int",
                    "val" => $_POST['plot' . (string)$i]
                ];
                
                $amount = [
                    "type" => "int",
                    "val" => $_POST['amount' . (string)$i]
                ];
                
                $data = array($NULL, $deliveryNoteId, $plotId, $amount);
                $conn -> insertInto('T_CropVolumeDistribution', $data);
                $i++;
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        }
    }
    $conn = new Mysql();
    $conn -> dbConnect();
    // Select amount from delivery note
    $conn -> select('T_DeliveryNote', 'year, nr, amount', 'id = ' . $_GET['id']);
    $delivery = $conn -> getFirstRow();
    // Distribution data
    $distData = $conn -> select('T_CropVolumeDistribution', '*', 'deliveryNoteId = ' . $_GET['id']);

    $conn -> dbDisconnect();
    $conn = NULL;

    if($distData -> num_rows > 0) {
        $i = 1;
        $tableData = '';
        while($row = $distData->fetch_assoc()) {
            $tableData .= '<tr>';
            $tableData .= '<td>' . plotSelectBox('plot' . (string)$i, $row['plotId']) . '</td>';
            $tableData .= '<td><input name="amount' . (string)$i . '" class="right" type="number" onkeyup="sumDistribution()" value="' . $row['amount'] . '" required></td>';
            $tableData .= '</tr>';
            $i++;
        }

    }




?>
<form action="?id=<?php echo $_GET['id']; ?>&update=1" method="post">
    <table id="delivery" class="completeWidth">
        <tr>
            <th width="70%" class="center">Gesamte Liefermenge von Lieferschein <strong><?php echo $delivery['year'] . ' ' . $delivery['nr']; ?></strong></th>
            <th width="30%" class="right"><?php echo $delivery['amount']; ?></th>
        </tr>
    </table>
    <table id="distribution" class="completeWidth">
        <tr>
            <th width="70%" class="center">Flurstück</th>
            <th width="30%" class="center">Menge</th>
        </tr>
        <?php if(isset($tableData)) echo $tableData; ?>
    </table>
    <table class="completeWidth">
        <tr>
            <th width="70%" class="center">Summe über die Flurstücke</th>
            <th width="30%" class="right" id="distSum">4000</th>
        </tr>
    </table>
    <button>Übernehmen</button>
</form>
<button onclick="addRow('distribution')">Flurstück hinzufügen</button>
<button onclick="deleteRow('distribution')">Flurstück entfernen</button>
<script>
    function sumDistribution() {
        
        
        var tableRef = document.getElementById("distribution");
        var sumtbl = 0;

        
        for(var i = 1; i < tableRef.rows.length; i++) {
            sumtbl += parseInt(tableRef.rows[i].cells[1].getElementsByTagName("input")[0].value);
        }

        document.getElementById("distSum").innerHTML = sumtbl;
        
        if(parseInt(document.getElementById("delivery").rows[0].cells[1].innerHTML) < sumtbl) {
            document.getElementById("distSum").classList.add('red');
        } else {
            document.getElementById("distSum").classList.remove('red');
        }
        
    }
    
    function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}
    
    function addRow(tableID) {
        var tableRef = document.getElementById('distribution');
        
        var selectBox = "<td><?php echo addslashes(plotSelectBox()); ?></td>";
        var numInput = "<td><input name=\"amount" + tableRef.rows.length.toString() + "\" class=\"right\" type=\"number\" onkeyup=\"sumDistribution()\" required></td>";
        var row = htmlToElement(selectBox);
        
        row.getElementsByTagName("select")[0].setAttribute("name", "plot" + tableRef.rows.length.toString());
        
        var newRow   = tableRef.insertRow(tableRef.rows.length);
        newRow.innerHTML = row.outerHTML + numInput;
    }
    
    function deleteRow(tableId) {
        var tableRef = document.getElementById('distribution');
        tableRef.deleteRow(tableRef.rows.length - 1);
    }
    
    if (document.getElementById('distribution').rows.length == 1) addRow('distribution');
    sumDistribution();
</script>
<?php
    include 'modules/footer.php';
?>