<?php
/*
* developerOptions.php
* ----------------
* This page can be used to change settings for debugging.
*
* @Author: David Hein
*/
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isDeveloper()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    if(isset($_GET['apply'])) {
        if(secPOST('showQuery')) {
            $_SESSION['devOpt_ShowQuery'] = true;
        } else {
            if(isset($_SESSION['devOpt_ShowQuery'])) {
                unset($_SESSION['devOpt_ShowQuery']);
            }
        }
    }
?>
<h1>Entwickleroptionen</h1>

<form action="?apply=1" method="post">
    <label>
        <input type="hidden" name="showQuery" value="0">
        <input type="checkbox" name="showQuery" value="1" <?php if(isset($_SESSION['devOpt_ShowQuery']) && $_SESSION['devOpt_ShowQuery']) { echo ' checked'; } ?>>
        SQL Queries anzeigen
    </label><br>
    <div class="warning">
        Das Aktivieren kann zu Fehlern führen, da die Ausgabe auch in Drobdowns eingefügt werden kann.
    </div>
    <button>Übernehmen</button>
</form>

<?php
    include 'modules/footer.php';
?>