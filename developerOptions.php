<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isDeveloper()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    if(isset($_GET['apply'])) {
        if($_POST['showQuery']) {
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
    <button>Übernehmen</button>
</form>

<?php
    include 'modules/footer.php';
?>