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

## Aufgabenübersicht
- [ ] **Bestandteile fertigstellen**  
  Lieferanten
    - [ ] Hinzufügen
    - [ ] Bearbeiten
    - [ ] Löschen
    - [ ] Anzeigen
  
  Lieferscheine
    - [ ] Hinzufügen
    - [ ] Bearbeiten
    - [ ] Löschen
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
