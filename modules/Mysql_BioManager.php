<?php
/*
* Mysql_BioManager.php
* --------------------
* This file contains the functions for a simpler use of SQL queries.
* The functions use the Mysql class and only have the minimum parameters.
* The table name is coded in the function.
*
* This has the advantage that by using this functions, this is the only
* place where the queries have to be changed.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

/*
* Get a permission for a given user id.
* Returns false if not no data has been found.
*/
function getUserPermission($userId, $permission) {
    // Get user permissions
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_UserPermission', $permission, 'userId =' . $userId);
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if ($result -> num_rows == 0) {
        return false;
    }
    else {
        $row = $result->fetch_assoc();
        return $row[$permission];
    }
    return false;
}

?>