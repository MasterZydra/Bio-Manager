<?php
/*
* deleteForm.php
* --------------
* Template for deleting an entry in the data base.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

include 'templates/form.php';

class deleteForm extends form {
    public $linkAllElements;
    
    public $table;
    
    public $overviewPage;
    
    function __construct() {
        parent::__construct();
        $this -> linkAllElements    = '<a href="index.php">Startseite</a>';
        
        $this -> table              = 'T_Table';
        
        $this -> overviewPage       = 'index.php';
    }
    
    function show($ownCode = "") {
        $code = "
            <?php
                \$showDialog = true;
                if(!isset(\$_GET['id'])) {
                    echo '<div class=\"warning\">';
                    echo 'Es wurde kein Lieferant übergeben. Zurück zu " . $this -> linkAllElements . "';
                    echo '</div>';
                }
                \$conn = new Mysql();
                \$conn -> dbConnect();
                \$conn -> select('" . $this -> table . "', '*', 'id = ' . \$_GET['id']);
                \$row = \$conn -> getFirstRow();
                \$conn -> dbDisconnect();
                \$conn = NULL;
                // Check if id is valid
                if (\$row == NULL) {
                    echo '<div class=\"warning\">';
                    echo 'Der ausgewählte Eintrag wurde in der Datenbank nicht gefunden. Zurück zu " . $this -> linkAllElements ."';
                    echo '</div>';
                    \$showDialog = false;
                } else {
                    \$conn = new Mysql();
                    \$conn -> dbConnect();
                    if(isset(\$_GET['delete'])) {
                        \$conn -> delete('" . $this -> table . "', 'id = ' . \$_GET['id']);
                        echo '<div class=\"infobox\">';
                        echo 'Der Eintrag  wurde gelöscht.';
                        echo '</div>';
                        \$showDialog = false;
                    }
                    \$conn -> dbDisconnect();
                    \$conn = NULL;
                }
            if(\$showDialog) {?>
                <form action=\"?id=<?php echo \$row['id']; ?>&delete=1\" method=\"post\">
                    Wollen Sie den Eintrag wirklich löschen?<br>
                    <button>Ja</button><button type=\"button\" onclick=\"window.location.href='" . $this -> overviewPage . "'\">Abbrechen</button>
                </form>
            <?php
            }
            ?>";

        parent::show();

        betterEval($code);
    }
}
?>