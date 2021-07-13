# Generatoren für HTML Elemente
Für die Vereinheitlichung und Vereinfachung der Verwendung von Tabellen, Auswahlboxen, ... gibt es PHP-Klassen, welche diese Elemente nach der Übergabe von entsprechenden Parametern generieren und dadurch ein einheitliches Bild entsteht.

- [Tabellen](#tabellen)

## Tabellen
**Klasse:** `tableGenerator`  
**Kurzbeschreibung:** Erzeugen von Tabellen durch Übergabe der Daten, Spalten, sowie Spaltenüberschriften. Zudem gibt es Einstellungen für Aktionen einzelner Zeilen und das Öffnen in einem neuen Reiter.

### Datentypen / Formatierung einer Spalte
Die Übergabe der Spaltennamen erfolgt in einem Array. Beispielsweise `array('name', ['inactive', 'bool'])`. Wenn nur der Name (bspw `name`) angegeben wird, wird das Standardformat für die Ausgabe verwendet (linksbündig, als Text, ohne besondere Formatierung). Wenn man den Namen und Datentyp in einen eigenes Array packt (bspw `['inactive', 'bool']`) wird diese Spalte anders formatiert. Es kann die Positionierung (_left, right, center_) des Datum, sowie die Darstellung des Datum selbst(_Datum als dd.mm.YYYY, Zahlen mit Komma und Punkt als Separatoren, Bool als Ja|Nein_) geändert werden.

Unterstützte Datentypen:
* `bool`
* `date`
* `float `
* `int`
* `currency`