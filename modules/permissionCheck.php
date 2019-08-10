<?php
include 'modules/Mysql.php';

function checkPermission($permission) {
    // Get user permissions
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> selectWhere('T_UserPermission', 'userId', '=', $_SESSION['userId'], 'int');
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

function isAllowedToEditVendor() {
    return checkPermission('editVendor');
}

function isDeveloper() {
    return checkPermission('isDeveloper');
}

function isAdmin() {
    return checkPermission('isAdmin');
}

function isLoggedIn() {
    return isset($_SESSION['userId']);
}

// Show PHP messages and warnings if user is developer
if(isDeveloper()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

?>