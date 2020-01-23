<?php
/*
* configChecker.php
* -----------------
* Check if all necessary configurations exist and are set.
*
* @Author: David Hein
*/

    // ---------  DatabaseConfig  ---------
    if (file_exists('config/DatabaseConfig.php'))
        include_once 'config/DatabaseConfig.php';

    // Check if file exists and all settings are set
    if (!file_exists('config/DatabaseConfig.php') ||
        !isset($database["server_name"]) ||
        !isset($database["database_name"]) ||
        !isset($database["database_username"]) ||
        !isset($database["database_password"]))
    {
        showWarningWithUrl(
            'Die Einstellungen für die <strong>Datenbankverbindung</strong> fehlen oder sind nicht vollständig!',
            'editDBConnection.php',
            'Bitte konfigurieren');
    }

    // ---------  ImpressumConfig  ---------
    if (file_exists('config/ImpressumConfig.php'))
        include 'config/ImpressumConfig.php';

    // Check if file exists and all settings are set
    if (!file_exists('config/ImpressumConfig.php') ||
        !isset($impressum["provider_name"]) ||
        !isset($impressum["provider_street"]) ||
        !isset($impressum["provider_postalCode"]) ||
        !isset($impressum["provider_city"]) ||
        !isset($impressum["provider_email"]) ||
        !isset($impressum["responsible_name"]) ||
        !isset($impressum["responsible_street"]) ||
        !isset($impressum["responsible_postalCode"]) ||
        !isset($impressum["responsible_city"]) ||
        !isset($impressum["responsible_email"]))
    {
        showWarningWithUrl(
            'Die Einstellungen für das <strong>Impressum</strong> fehlen oder sind nicht vollständig!',
            'editImpressum.php',
            'Bitte konfigurieren');
    }

    // ---------  InvoiceDataConfig  ---------
    if (file_exists('config/InvoiceDataConfig.php'))
        include 'config/InvoiceDataConfig.php';

    // Check if file exists and all settings are set
    if (!file_exists('config/InvoiceDataConfig.php') ||
        !isset($invoice["sender_name"]) ||
        !isset($invoice["sender_address"]) ||
        !isset($invoice["sender_postalCode"]) ||
        !isset($invoice["sender_city"]) ||
        !isset($invoice["bank"]) ||
        !isset($invoice["BIC"]) ||
        !isset($invoice["IBAN"]) ||
        !isset($invoice["author"]) ||
        !isset($invoice["name"]))
    {
        showWarningWithUrl(
            'Die Einstellungen für die <strong>Rechnung</strong> fehlen oder sind nicht vollständig!',
            'editInvoiceData.php',
            'Bitte konfigurieren');
    }

?>