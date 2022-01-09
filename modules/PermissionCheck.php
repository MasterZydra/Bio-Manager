<?php

/*
* permissionCheck.php
* ---------------
* This file contains functions for permission checks.
* It also enables showing PHP messages if user has developer permissions.
*
* @Author: David Hein
*/
include 'modules/Mysql_BioManager.php';
include_once 'modules/MySqlPreparedStatementBioManager.php';

include 'modules/stringSecurityHelper.php';
include 'modules/messageHelper.php';

/*
* Get permission for current user.
*
* @param string $permission Name of the permission/column in the data base
*
* @return Boolean if user has permission
*/
function checkPermission($permission)
{
    // Return always false, if visitor is not logged in
    if (!isset($_SESSION['userId'])) {
        return false;
    }
    // Get permission from database
    $prepStmt = new MySqlPreparedStatementBioManager();
    return $prepStmt -> getUserPermission($_SESSION['userId'], $permission);
    $prepStmt -> destroy();
}

/*
* Check if user has developer permissions
*
* @return Boolean if user has permission
*/
function isDeveloper()
{
    return checkPermission('isDeveloper');
}

/*
* Check if user has adminstrator permissions
*
* @return Boolean if user has permission
*/
function isAdmin()
{
    return checkPermission('isAdmin');
}

/*
* Check if user has maintainer permissions
*
* @return Boolean if user has permission
*/
function isMaintainer()
{
    return checkPermission('isMaintainer');
}

/*
* Check if user has inspector permissions
*
* @return Boolean if user has permission
*/
function isInspector()
{
    return checkPermission('isInspector');
}

/*
* Check if user has vendor permissions
*
* @return Boolean if user has permission
*/
function isVendor()
{
    return checkPermission('isVendor');
}

/*
* Check if user is logged in
*
* @return Boolean if user has permission
*/
function isLoggedIn()
{
    return isset($_SESSION['userId']);
}

/*
* Check if user is a supplier
*
* @return Boolean if user is supplier
*/
function isSupplier()
{
    $prepStmt = new MySqlPreparedStatement();
    $row = $prepStmt -> selectColWhereId("supplierId", "T_User", $_SESSION['userId']);
    $prepStmt -> destroy();

    return checkPermission('isSupplier') && !is_null($row) && !is_null($row['supplierId']);
}

/**
* Get supplier id for current user
*
* @author David Hein
* @return Supplier id or 0 if no id found
*/
function getUserSupplierId()
{
    $prepStmt = new MySqlPreparedStatement();
    $row = $prepStmt -> selectColWhereId("supplierId", "T_User", $_SESSION['userId']);
    $prepStmt -> destroy();

    if (is_null($row)) {
        return 0;
    } else {
        return $row['supplierId'];
    }
}

// Show PHP messages and warnings if user is developer
if (isDeveloper()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
