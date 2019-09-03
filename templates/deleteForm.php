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

/**
* The class form is generating an HTML template for a delete page.
* The content is set through properties. Indiviudal code can be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class deleteForm extends form {
    /**
    * HTML code which will be shown in message box as link to all elements.
    * E.g. '<a href="pricing.php">Alle Preise anzeigen</a>'
    * @var string
    */
    public $linkAllElements;

    /**
    * Table name where entry with given id will be deleted. E.g. 'T_User'
    * @var string
    */
    public $table;
    
    /**
    * Page which will be forwarded to after deleting. E.g. 'user.php'
    * @var string
    */
    public $overviewPage;
    
    /**
    * Code that will be executed before the call of the delete query.
    * With $conn the database connection can be called.
    * With $_GET['id'] the given id can be accessed.
    * E.g. "\$conn -> delete('T_UserLogin', 'userId=' . \$_GET['id']);"
    * @var string
    */
    public $queryBeforeDelete;
    
    /**
    * Construct a new deleteForm object and set default values for the properties
    *
    * @author David Hein
    */
    function __construct() {
        // Create parent
        parent::__construct();
        $this -> linkAllElements    = '<a href="index.php">Startseite</a>';
        
        $this -> table              = 'T_Table';
        
        $this -> overviewPage       = 'index.php';
        
        $this -> queryBeforeDelete  = '';
    }
    
    /**
    * Show the page content
    *
    * @param string $ownCode    If this parameter is set, the given string will be excuted
    *
    * @author David Hein
    */
    function show($ownCode = "") {
        $code = "
            <?php
                \$showDialog = true;
                if(!isset(\$_GET['id'])) {
                    echo '<div class=\"warning\">';
                    echo 'Es wurde kein Eintrag übergeben. Zurück zu " . $this -> linkAllElements . "';
                    echo '</div>';
                    \$showDialog = false;
                }
                if(\$showDialog && isset(\$_GET['id'])){
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
                        if(isset(\$_GET['delete'])) {" .
                            $this -> queryBeforeDelete .
                            "\$conn -> delete('" . $this -> table . "', 'id = ' . \$_GET['id']);
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
            }
            ?>";

        parent::show();

        betterEval($code);
    }
}
?>