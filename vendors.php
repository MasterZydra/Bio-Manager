<?php
    include 'modules/header.php';
?>

<h1>Lieferanten</h1>

<?php
    include 'modules/Mysql.php';
    include 'modules/helperFunctions.php';

    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->selectAll('T_Vendor');

    dataSetToTable($result, array('id', 'name'), array('Lieferant-Nr.', 'Name'));

    $conn->dbDisconnect();

    include 'modules/footer.php';
?>
