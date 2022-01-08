<?php

/*
* deleteForm.php
* --------------
* Template for deleting an entry in the data base.
*
* @Author: David Hein
*/

include 'templates/form.php';
include_once 'system/modules/database/mySQL/mySQL_prepStatement.php';

/**
* The class form is generating an HTML template for a delete page.
* The content is set through properties. Indiviudal code can be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class deleteForm extends form
{
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
    * The array needs to contain arrays which contain the [0] table name,
    * [1] where column and [2] id to check on.
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

    protected $prepStatement;

    /**
    * Construct a new deleteForm object and set default values for the properties
    *
    * @author David Hein
    */
    function __construct()
    {
        // Create parent
        parent::__construct();
        $this -> linkAllElements    = '<a href="index.php">Startseite</a>';

        $this -> table              = 'T_Table';

        $this -> overviewPage       = 'index.php';

        $this -> deleteBeforeDelete = array();
        $this -> updateBeforeDelete = array();

        $this->prepStatement = new MySQL_prepStatement();
    }

    /**
    * Close all open connections used in class
    */
    function destroy()
    {
        $this->prepStatement->destroy();
    }

    /**
    * Delete actions before deleting main entry.
    *
    * author David Hein
    */
    protected function deleteBeforeDelete()
    {
        $i = 0;
        while (count($this -> deleteBeforeDelete) > $i && $this -> deleteBeforeDelete[$i] != null) {
            $this->prepStatement->deleteWhereCol(
                $this -> deleteBeforeDelete[$i][0],
                $this -> deleteBeforeDelete[$i][1],
                $this -> deleteBeforeDelete[$i][2]
            );
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
    protected function updateBeforeDelete($conn)
    {
        $i = 0;
        while (count($this -> updateBeforeDelete) > $i && $this -> updateBeforeDelete[$i] != null) {
            $conn -> update(
                $this -> updateBeforeDelete[$i][0],
                $this -> updateBeforeDelete[$i][1],
                $this -> updateBeforeDelete[$i][2]
            );
            $i++;
        }
    }

    /**
    * Contains logic for showing the deleting form and delete the entry.
    *
    * @author David Hein
    */
    protected function deleteLogic()
    {
        // Check if id is given
        if (!isset($_GET['id'])) {
            showWarning('Es wurde kein Eintrag übergeben. Zurück zu ' . $this -> linkAllElements);
            return;
        }

        // Get data from DB
        $dataSet = $this->prepStatement->selectWhereId($this->table, intval(secGET('id')));
        $row = MySQL_prepStatement::getFirstRow($dataSet);

        // Check if id is valid
        if ($row == null) {
            // Warning if no entry in DB was found
            showWarning('Der ausgewählte Eintrag wurde in der Datenbank nicht gefunden. '
                . 'Zurück zu ' . $this -> linkAllElements);
            return;
        }

        // Delete entry
        if (isset($_GET['delete'])) {
            $conn = new Mysql();
            $conn -> dbConnect();
            // Before delete actions
            $this -> deleteBeforeDelete();
            $this -> updateBeforeDelete($conn);
            // Delete main entry
            $this->prepStatement->deleteWhereId($this -> table, intval($row['id']));
            // Close open connection
            $conn -> dbDisconnect();
            $conn = null;

            showInfobox('Der Eintrag  wurde gelöscht.');
            return;
        }

        ?>
        <form action="?id=<?php echo $row['id']; ?>&delete=1" method="post">
            Wollen Sie den Eintrag wirklich löschen?<br>
            <button>Ja</button><button type="button" onclick="window.location.href='<?php echo $this -> overviewPage; ?>'">Abbrechen</button>
        </form>
        <?php
    }

    /**
    * Main function which calls all parts that will be executed.
    * It creates the page which will be shown.
    *
    * @author David Hein
    */
    public function show()
    {
        $this -> head();
        $this -> deleteLogic();
        $this -> foot();

        $this -> destroy();
    }
}
?>