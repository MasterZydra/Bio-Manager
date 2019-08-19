<?php
/*
* logout.php
* ---------------
* This form is used to logout from the internal area.
* The session gets destroyed.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
?>