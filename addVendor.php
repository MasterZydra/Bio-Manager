
<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
    // If not logged in
  //  if(!isset($_SESSION['userId'])) {
//        header("Location: index.php");
//        exit();
  //  }
   // else {
        // If not admin rights
   // if ($_SESSION['isAdmin'] != 1) {
//            header("Location: index.php");
//            exit();
    // }
        // Administration area
    // else {

include 'modules/header.php';

include 'modules/Mysql.php';


$conn = new Mysql();

$conn -> dbConnect();
$result = $conn->selectAll('T_Vendor');


    if ($result->num_rows > 0) {
               echo '<table>';
        echo '<tbody>';
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '  <td>' . $row['id'] . '</td>';
            echo '  <td>' . $row['name'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

$conn->dbDisconnect();



echo $_POST["vendor_name"];

include 'modules/footer.php';

    //    }
  //  }

exit();
?>


<?php
/*
            }
            else
            {
                // Create connection
                $conn = new mysqli("localhost", "StockAdmin", "GiemgasJiamEx$");
                // Check connection
                if ($conn->connect_error) {
                    if (isset($_SESSION['isDeveloper']) AND $_SESSION['isDeveloper'] == 1) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    else {
                        die("Connection failed");
                    }
                }
                else {
                    $symbol = $_GET['symbol'];
            
                    $sql = "SELECT symbol, company FROM StockKeyFigures.T_Stocks WHERE symbol like '" . $symbol . "'";
                    $result = $conn->query($sql);
            
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
?>
<h3 class="red">Aktie <?php echo $row['symbol'] . ' - ' . $row['company']; ?> bereits in DB.</h3>
<h3><a href=<?php echo '"index.php?action=updateData&symbol=' . $row['symbol'] . '"'; ?>>Daten aktualisieren?</a></h3>
<h3><a href="index.php?action=addStock">Weitere hinzufügen?</a></h3>
<?php
                    }
                    else {
                        $data = file_get_contents("https://api.iextrading.com/1.0/stock/" . $symbol . "/stats");
                        $json = json_decode($data, true);
                        
                        if ($json['symbol'] == '') {
                            echo '<h3 class="red">Symbol "' . $symbol . '" nicht gefunden</h3>';
                            echo '<h3><a href="index.php?action=addStock">Erneut versuchen?</a></h3>';
                        }
                        else {
                            echo '<h3>' . $json['symbol'] . ' - ' . $json['companyName'] . '</h3>';
                            $sql = "INSERT INTO StockKeyFigures.T_Stocks (symbol, company) VALUES ('" . $json['symbol'] . "', '" . $json['companyName'] . "')";
                            if ($conn->query($sql) === TRUE) {
    ?>
                            <h3>Aktie erfolgreich hinzugefügt.</h3>
                            <h3><a href="addStock.php">Weitere hinzufügen?</a></h3>
    <?php
                            echo '<h3><a href="index.php?action=updateData&symbol=' . $symbol . '">Daten aktualisieren?</a></h3>';
                            }
                            else {
                                if ($_SESSION['isDeveloper'] == 1) {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                else {
                                    echo "Fehler beim Einfügen der Daten aufgetreten. Bitte Entwickler benachrichtigen.";
                                }
                            }
                        }
                    }
                }
            }
        }
    }*/
?>


