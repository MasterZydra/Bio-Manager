# Sicherheitschecks
In diesem Dokument werden die durchgeführten Sicherheitschecks und durchgeführten Maßnahmen dokumentiert.

[20.09.2019 - SQL Injections](#20092019---sql-injections)  
[27.11.2019 - HTML Injections in Formularen](#27112019---html-injections-in-formularen)

## 27.11.2019 - HTML Injections in Formularen
**Versuch einer HTML Injection bei Formularen**  
Im Versuch sollte geprüft werden, was passiert, wenn man HTML z.B. `<h2>text</h2>` als Text in ein Eingabefeld eingibt. Wird dieser vom Browser ausgeführt?

**Vermutung**: Da aktuell keine Behandlung diese Problems implementiert ist, wird das HTML eins zu eins umgesetzt.

**Behebung**: Vor dem Anzeigen und Verwenden der POST- und GET-Werte wird auf den Text die Funktion `htmlspecialchars()` angewendet um den HMTL Code zu maskieren. Für eine einfachere Verwendung wurde eine Methode `secPOST($name)` und `secGET($name)` definiert. Diese geben den entsprechenden POST- oder GET-Wert zurück, jedoch mit maskiertem HMTL.  
Die neuen Methoden müssen noch auf alle Seiten übernommen werden (Stand 27.11.2019).

**Beurteilung**: Der Nutzer des Systems kann dadurch getäuscht werden. Durch JavaScript könnte Einfluss auf die Felder genommen werden.

## 20.09.2019 - SQL Injections
**Versuch einer SQL Injektion beim Login**  
Da der Aufbau des SQL Statements bekannt ist, konnte eine Injection sehr direkt ohne großes Ausprobieren für die Ermittlung der Struktur durchgeführt werden.

Select Query: `SELECT * FROM T_UserLogin WHERE login = '<login-Feld>'`  
Durch die Eingabe des Logins `test'; DELETE FROM T_UserLogin WHERE login='test` kann ein Delete Statement in die Abfrage eingebracht werden. Lässt man sich die Fehlermeldungen und ausgeführten Abfragen anzeigen, stellt man fest, dass das Statement an sich korrekt ist, jedoch nicht ausgeführt wird.

Der Grund liegt in der Ausführungslogik. Die Methode `query(<Query>)` lässt nur eine Abfrage zu. Zum Ausführen von mehreren Abfragen gibt es die Methode `multi_query(<Query>)`.

—> Somit ist das Ausführen einer Injection mit mehreren Abfragen nicht möglich. Hätte man Zugriff auf eine Delete-Seite könnte man jedoch den Parameter `id` in der URL nutzen um das Delete Statement so anzupassen, dass alle Einträge gelöscht werden können.

—> Temporärer Fix: Bei Delete-Form `$row['id']` verwenden. Somit ist es durch das Ändern der id nicht direkt möglich das Delete Statement zu manipulieren.

—> Langfristiger Schutz gegen SQL Injections durch die Verwendung von **PHP Prepared Statements** . Durch diese Technik kann in die Platzhalter kein SQL injiziert werden.