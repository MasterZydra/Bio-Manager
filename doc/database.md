# Datenbankstruktur
## Tabellen
| Tabelle | Beschreibung |
| --- | --- |
| **Benutzerverwaltung**|
| [T_User](#t_user) | Enthält die Benutzer mit ihrem Namen und ggf. Lieferanten-Nummer |
| [T_UserLogin](#t_userlogin)| Enthält Anmeldedaten der Benutzer und die Einstellung für das Ändern des Passworts beim nächsten Anmelden |
| [T_UserPermission](#t_userpermission)| Enthält Berechtigungen der Benutzer |
| **Nutzdaten** |
| [T_CropVolumeDistribution](#t_cropvolumedistribution) | Zuweisung der Liefermenge eines Lieferscheines auf mehrere Flurstücke |
| [T_DeliveryNote](#t_deliverynote) | Enthält die Lieferscheine |
| [T_Invoice](#t_invoice) | Enthält alle Rechnungs-Metadaten. |
| [T_Plot](#t_plot) | Enthält die Flurstücke |
| [T_Pricing](#t_pricing) | Enthält die Preise pro Jahr |
| [T_Product](#t_product) | Enthält die Produkte |
| [T_Recipient](#t_recipient) | Enthält die Abnehmer der Produkte |
| [T_Setting](#t_setting) | Enthält Einstellungen für das ganze System. Zum Beispiel die Einheit der Menge (kg). |
| [T_Supplier](#t_supplier) | Enthält die Lieferanten |

## Benutzerverwaltung
### T_User
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Benutzers |
| name | varchar(30) | Name des Benutzers |
| supplierId | int(11) | Lieferanten ID in [T_Supplier](#t_supplier) |

### T_UserLogin
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID der Zeile |
| userId | int(11) | ID des Benutzers in [T_User](#t_user) |
| login | varchar(20) | Benutzername für Anmeldung |
| password | varchar(255) | Verschlüsseltes Passwort |
| forcePwdChange | tinyint(1) | Flag für Änderung des Passworts bei nächster Anmeldung |

### T_UserPermission
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID der Zeile |
| userId | int(11) | ID des Benutzers in [T_User](#t_user) |
| isAdmin | tinyint(1) | Flag für Administrator-Berechtigung |
| isDeveloper | tinyint(1) | Flag für Entwickle-Berechtigung |
| isMaintainer | tinyint(1) | Flag für Pflege-Berechtigung |
| isSupplier | tinyint(1) | Flag für Lieferanten-Berechtigung |
| isInspector | tinyint(1) | Flag für Prüfer-Berechtigung |

## Nutzdaten
### T_CropVolumeDistribution
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Eintrags |
| deliveryNoteId | int(11) | Lieferschein in [T_DeliveryNote](#t_deliverynote) |
| plotId | int(11) | Flurstück in [T_Plot](#t_plot) |
| amount | decimal | Liefermenge |

### T_DeliveryNote
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Lieferscheins |
| year | int(4) | Jahr der Lieferung|
| nr | int(2) | Nummer des Lieferscheins im Lieferjahr |
| deliverDate | date | Lieferdatum |
| amount | decimal | Liefermenge |
| productId | int(11) | Geliefertes Produkt ([T_Product](#t_product)) |
| supplierId | int(11) | Lieferant in [T_Supplier](#t_supplier) |
| invoiceId | int(11) | Rechnung in welcher der Lieferschein gelistet ist ([T_Invoice](#t_invoice)) |

### T_Invoice
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID der Rechnung |
| year | int(4) | Jahr der Rechnung |
| nr | int(11) | Nummer der Rechnung im Jahr |
| invoiceDate | date | Erstelldatum der Rechnung |
| isPaid | tinyint(1) | Flag ob die Rechnung bezahlt ist |
| recipientId | int(11) | Empfänger der Rechnung ([T_Recipient](#t_recipient)) |

### T_Plot
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Flurstücks |
| nr | varchar(30) | Nummer des Flurstücks |
| name | varchar(100) | Name des Flurstücks |
| subdistrict | varchar(50) | Gemarkung |
| supplierId | int(11) | Lieferant in [T_Supplier](#t_supplier) |

### T_Pricing
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Preises |
| productId | int(11) | Produkt ([T_Product](#t_product)) |	
| year | int(4) | Jahr des Preises |
| price | float | Preis für das Jahr |
| pricePayOut | float | Preis welcher ausgezahlt wird |

### T_Product
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Produktes |
| name | varchar(50) | Name des Produktes |

### T_Recipient
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Abnehmers |
| name | varchar(100) | Name des Abnehmers |
| address | varchar(255) | Adresse des Abnehmers |

### T_Setting
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID der Einstellung |
| name | varchar(30) | Name der Einstellung |
| description | varchar(30) | Beschreibung der Einstellung |
| value | varchar(300) | Wert der Einstellung |

### T_Supplier
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID des Lieferanten |
| name | varchar(100) | Name des Lieferanten |
| inactive | tinyint(1) | Lieferant ist nicht mehr aktiv |