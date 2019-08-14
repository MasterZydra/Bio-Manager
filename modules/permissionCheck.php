<?php
/*
* permissionCheck.php
* ---------------
* This file contains functions for permission checks.
* It also enables showing PHP messages if user has developer permissions.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
include 'modules/Mysql.php';
include 'modules/Mysql_BioManager.php';

/*
* Get permission for current user.
*
* @param string $permission Name of the permission/column in the data base
*
* @return Boolean if user has permission
*/
function checkPermission($permission) {
    return getUserPermission($_SESSION['userId'], $permission);
}

/*
* Check if user has developer permissions
*
* @return Boolean if user has permission
*/
function isDeveloper() {
    return checkPermission('isDeveloper');
}

/*
* Check if user has adminstrator permissions
*
* @return Boolean if user has permission
*/
function isAdmin() {
    return checkPermission('isAdmin');
}

/*
* Check if user has maintainer permissions
*
* @return Boolean if user has permission
*/
function isMaintainer() {
    return checkPermission('isMaintainer');
}

/*
* Check if user has inspector permissions
*
* @return Boolean if user has permission
*/
function isInspector() {
    return checkPermission('isInspector');
}

/*
* Check if user has vendor permissions
*
* @return Boolean if user has permission
*/
function isVendor() {
    return checkPermission('isVendor');
}

/*
* Check if user is logged in
*
* @return Boolean if user has permission
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