<?php
include 'modules/Mysql.php';
include 'modules/Mysql_BioManager.php';

/*
* Get permission for current user.
*/
function checkPermission($permission) {
    return getUserPermission($_SESSION['userId'], $permission);
}

/*
* Check if user has developer permissions
*/
function isDeveloper() {
    return checkPermission('isDeveloper');
}

/*
* Check if user has adminstrator permissions
*/
function isAdmin() {
    return checkPermission('isAdmin');
}

/*
* Check if user has maintainer permissions
*/
function isMaintainer() {
    return checkPermission('isMaintainer');
}

/*
* Check if user has inspector permissions
*/
function isInspector() {
    return checkPermission('isInspector');
}

/*
* Check if user has vendor permissions
*/
function isVendor() {
    return checkPermission('isVendor');
}

/*
* Check if user is logged in
*/
function isLoggedIn() {
    return isset($_SESSION['userId']);
}

// Show PHP messages and warnings if user is developer
if(isDeveloper()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

?>