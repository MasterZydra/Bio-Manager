<?php

/*
* permissionCheck.php
* ---------------
* This file contains functions for permission checks.
* It also enables showing PHP messages if user has developer permissions.
*
* @Author: David Hein
*/
include 'Modules/Mysql_BioManager.php';
include_once 'Modules/MySqlPreparedStatementBioManager.php';

include 'Modules/stringSecurityHelper.php';
include 'Modules/messageHelper.php';

/* Get permission for current user */
function checkPermission(string $permission): bool
{
    // Return always false, if visitor is not logged in
    if (!isset($_SESSION['userId'])) {
        return false;
    }
    // Get permission from database
    $prepStmt = new \MySqlPreparedStatementBioManager();
    return $prepStmt -> getUserPermission($_SESSION['userId'], $permission);
    $prepStmt -> destroy();
}

/* Check if user has developer permissions */
function isDeveloper(): bool
{
    return checkPermission('isDeveloper');
}

/* Check if user has adminstrator permissions */
function isAdmin(): bool
{
    return checkPermission('isAdmin');
}

/* Check if user has maintainer permissions */
function isMaintainer(): bool
{
    return checkPermission('isMaintainer');
}

/* Check if user has inspector permissions */
function isInspector(): bool
{
    return checkPermission('isInspector');
}

/* Check if user has vendor permissions */
function isVendor(): bool
{
    return checkPermission('isVendor');
}

/* Check if user is logged in */
function isLoggedIn(): bool
{
    return isset($_SESSION['userId']);
}

/* Check if user is a supplier */
function isSupplier(): bool
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
