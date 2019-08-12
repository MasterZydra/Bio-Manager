# Bio-Manager
Diese Website ist eine Plattform für das vereinfachte Dokumentieren der Obstlieferungen für das Bio-Zertifikat.
Die Lieferscheine, Lieferanten und Flurstücke werden eingetragen. Die Mengen der Lieferscheine werden auf die Flurstücke aufgeteilt.

Aus den Daten werden die Rechnungen und Auszahlungen generiert. Übersichten für die Kasse des Vereins und für die Bio-Zertifizierungstelle können erstellt werden.

## Datenbankstruktur
| Tabelle | Beschreibung |
| --- | --- |
| **T_DeliveryNote** | Enthält die Lieferscheine |
| **T_Vendor** | Enthält die Lieferanten |
| **T_User** | Enthält die Benutzer mit ihrem Namen und ggf. Lieferanten-Nummer |
| **T_UserLogin** | Enthält Anmeldedaten der Benutzer und die Einstellung für das Ändern des Passworts beim nächsten Anmelden |
| **T_UserPermission** | Enthält Berechtigungen der Benutzer |

### T_DeliveryNote
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID of the delivery note |
| year | int(4) | Year of delivery|
| nr | int(2) | Number of delivery note in the delivery year |
| deliveryDate | date | Date of the delivery |
| amount | decimal | Delivered amount |
| vendorId | int(11) | vendor in T_Vendor |

### T_Vendor
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID of vendor |
| name | varchar(100) | Name of vendor |

### T_User
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID of user |
| name | varchar(30) | Name of the user |
| vendorId | int(11) | vendor in T_Vendor |

### T_UserLogin
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID of the user login |
| userId | int(11) | ID of user in T_User |
| login | varchar(20) | Username of login |
| password | varchar(255) | Hashed password |
| forcePwdChange | tinyint(1) | Flag to force user to change password after next login |

### T_UserPermission
| Spalte | Datentyp | Beschreibung |
| --- | :-: | --- |
| id | int(11) | ID of the user permission |
| userId | int(11) | ID of the user in T_User |
| isAdmin | tinyint(1) | Flag for administrator permission |
| isDeveloper | tinyint(1) | Flag for developer permission |
| isMaintainer | tinyint(1) | Flag for maintainer permission |
| isVendor | tinyint(1) | Flag for vendor permission |
| isInspector | tinyint(1) | Flag for inspector permission |

## Aufgabenübersicht
- [x] **Bestandteile fertigstellen**  
  Benutzer
    - [ ] Hinzufügen
    - [ ] Bearbeiten
    - [ ] Löschen
    - [ ] Anzeigen
  
  Lieferscheine
    - [ ] Hinzufügen
    - [ ] Bearbeiten
    - [x] Löschen
    - [ ] Anzeigen
  
  Flurstücke
    - [ ] Hinzufügen
    - [ ] Bearbeiten
    - [ ] Löschen
    - [ ] Anzeigen

- [ ] **Optimierung**  
  SQL-Abfragen  
  Nur die benötigten Spalten abfragen
  Mysql.php - ggf. Wrapper damit aufruf mit wenigen Parametern möglich ist.

```
INSERT INTO `T_User` (`id`, `name`, `vendorId`) VALUES
(1, 'wurzel', 0);
INSERT INTO `T_UserLogin` (`id`, `userId`, `login`, `password`, `forcePwdChange`) VALUES
(1, 1, 'test', '$2y$10$Vaqb11MZXuA3k7/fUc0cIePGpAYsih6R6mC1SPqrMxTv9nsV6V7Bq', 0);
INSERT INTO `T_UserPermission` (`id`, `userId`, `isAdmin`, `isDeveloper`, `isMaintainer`, `isVendor`, `isInspector`) VALUES
(1, 1, 1, 0, 0, 0, 0);
```
