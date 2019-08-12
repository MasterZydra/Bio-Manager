<?php

/*
* Get a permission for a given user id.
* Returns false if not no data has been found.
*/
function getUserPermission($userId, $permission) {
    // Get user permissions
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> selectColumsWhere('T_UserPermission', $permission, 'userId =' . $userId);
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