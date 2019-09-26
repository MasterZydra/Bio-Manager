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
* 16.09.2019:
*   - Change logic. Does not use eval anymore.
* 23.09.2019:
*   - Use prepared statements for deleting the data
*/

include 'templates/form.php';
include_once 'modules/Mysql_preparedStatement_BioManager.php';

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
    * Table entries which will be deleted before main entry will be deleted.
    * The array needs to contain arrays which contain the [0] table name and
    * the [1] where condition.
    * @var array
    */
    public $deleteBeforeDelete;
    
    /**
    * Table entries which will be updated before main entry will be deleted.
    * The array needs to contain arrays which contain the [0] table name,
    * the [1] the set part and the [2] where condition.
    * @var array
    */
    public $updateBeforeDelete;
    
    
    protected $prepStmt;
    
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
        
        $this -> deleteBeforeDelete = array();
        $this -> updateBeforeDelete = array();
        
        $this -> prepStmt = new mysql_preparedStatement_BioManager();
    }
    
    /**
    * Close all open connections used in class
    */
    function destroy() {
        $this -> prepStmt -> destroy();
    }
    
    /**
    * Delete actions before deleting main entry.
    *
    * @param Connection $conn   Database connection
    *
    * author David Hein
    */
    protected function deleteBeforeDelete($conn) {
        $i = 0;
        while(count($this -> deleteBeforeDelete) > $i && $this -> deleteBeforeDelete[$i] != NULL) {
            $conn -> delete($this -> deleteBeforeDelete[$i][0], $this -> deleteBeforeDelete[$i][1]);
            $i++;
        }
    }
    
    /**
    * Update actions before deleting main entry.
    *
    * @param Connection $conn   Database connection
    *
    * author David Hein
    */
    protected function updateBeforeDelete($conn) {
        $i = 0;
        while(count($this -> updateBeforeDelete) > $i && $this -> updateBeforeDelete[$i] != NULL) {
            $conn -> update(
                $this -> updateBeforeDelete[$i][0],
                $this -> updateBeforeDelete[$i][1],
                $this -> updateBeforeDelete[$i][2]);
            $i++;
        }
    }
    
    /**
    * Contains logic for showing the deleting form and delete the entry.
    *
    * @author David Hein
    */
    protected function deleteLogic() {
        $showDialog = true;
        
        // Check if id is given
        if(!isset($_GET['id'])) {
            echo '<div class="warning">';
            echo 'Es wurde kein Eintrag übergeben. Zurück zu ' . $this -> linkAllElements;
            echo '</div>';
            $showDialog = false;
        }
        
        if($showDialog && isset($_GET['id'])){
            // Get data from DB
            $conn = new Mysql();
            $conn -> dbConnect();
            $conn -> select($this -> table, '*', 'id = ' . $_GET['id']);
            $row = $conn -> getFirstRow();
            $conn -> dbDisconnect();
            $conn = NULL;
            
            // Check if id is valid
            if ($row == NULL) {
                // Warning if no entry in DB was found
                echo '<div class="warning">';
                echo 'Der ausgewählte Eintrag wurde in der Datenbank nicht gefunden. '
                    . 'Zurück zu ' . $this -> linkAllElements;
                echo '</div>';
                $showDialog = false;
            } else {
                // Delete entry
                $conn = new Mysql();
                $conn -> dbConnect();
                if(isset($_GET['delete'])) {
                    // Before delete actions
                    $this -> deleteBeforeDelete($conn);
                    $this -> updateBeforeDelete($conn);
                    // Delete main entry
                    $this -> prepStmt -> deleteWhereId($this -> table, $row['id']);
                    
                    echo '<div class="infobox">';
                    echo 'Der Eintrag  wurde gelöscht.';
                    echo '</div>';
                    $showDialog = false;
                }
                $conn -> dbDisconnect();
                $conn = NULL;
            }
            if($showDialog) {
?>
    <form action="?id=<?php echo $row['id']; ?>&delete=1" method="post">
        Wollen Sie den Eintrag wirklich löschen?<br>
        <button>Ja</button><button type="button" onclick="window.location.href='<?php echo $this -> overviewPage; ?>'">Abbrechen</button>
    </form>
<?php
            }
        }
    }
    
    /**
    * Main function which calls all parts that will be executed.
    * It creates the page which will be shown.
    *
    * @author David Hein
    */
    public function show() {
        $this -> head();
        $this -> deleteLogic();
        $this -> foot();
        
        $this -> destroy();
    }
}
?>