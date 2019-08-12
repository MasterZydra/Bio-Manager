<?php
include 'modules/Mysql.php';
include 'modules/Mysql_BioManager.php';

function checkPermission($permission) {
    return getUserPermission($_SESSION['userId'], $permission);
}

function isDeveloper() {
    return checkPermission('isDeveloper');
}

function isAdmin() {
    return checkPermission('isAdmin');
}

function isMaintainer() {
    return checkPermission('isMaintainer');
}

function isVendor() {
    return checkPermission('isVendor');
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