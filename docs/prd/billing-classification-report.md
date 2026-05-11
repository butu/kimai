# PRD: Abrechnungsprüfung nach Abrechnungsart

## Problem Statement

WEBprofil erfasst Arbeitszeiten in Kimai, rechnet Projekte aber je nach Projektart unterschiedlich ab:

- Pauschalprojekte werden über das CRM `kunden.webprofil.at` abgerechnet.
- Aufwandsprojekte werden in Redmine `aufgaben.webprofil.at` über Tickets gebucht und gelangen von dort per API ins CRM.

Aktuell gibt es in Kimai keine strukturierte Verbindung zu diesen Abrechnungsarten. Dadurch ist schwer prüfbar, wie viele verrechenbare Stunden in einem Abrechnungsmonat auf Projekte nach Aufwand entfallen und ob diese Größenordnung zu den in Redmine/CRM abgerechneten Stunden passt.

Das konkrete Kontrollbedürfnis ist zunächst nicht ein automatischer Redmine- oder CRM-Abgleich, sondern eine einfache Kimai-interne Übersicht: pro Mitarbeiter und Monat sollen die verrechenbaren Stunden nach Projekt-Abrechnungsart sichtbar sein.

## Solution

Kimai erhält am Projekt ein neues Feld **Abrechnungsart**. Dieses unterscheidet Projekte in:

- `flat` = Pauschal
- `atcost` = Nach Aufwand
- `null` = Nicht klassifiziert, nur für bestehende Altdaten

Zusätzlich entsteht ein neuer Admin-Report **Abrechnungsprüfung** im Reporting-Bereich. Der Report zeigt für einen ausgewählten Monat pro Benutzer die Summe der verrechenbaren, abgeschlossenen Zeitbuchungen, getrennt nach Abrechnungsart der jeweiligen Projekte.

Der Report dient als manuelle Kontrollbasis für den späteren Vergleich mit Redmine/CRM. Pauschalprojekte werden nicht gegen Redmine geprüft, bleiben aber als eigene Spalte sichtbar. Nicht klassifizierte Projekte werden ebenfalls sichtbar, damit Datenlücken gezielt nachgepflegt werden können.

## User Stories

1. Als Admin möchte ich bei jedem Projekt eine Abrechnungsart hinterlegen, damit Kimai Pauschal- und Aufwandsprojekte unterscheiden kann.
2. Als Admin möchte ich zwischen „Pauschal“ und „Nach Aufwand“ wählen können, damit die fachliche Abrechnungslogik eindeutig abgebildet ist.
3. Als Admin möchte ich technische Werte `flat` und `atcost` verwenden, damit die Daten stabil und sprachunabhängig gespeichert werden.
4. Als Admin möchte ich bestehende Projekte ohne Abrechnungsart weiter im System behalten können, damit die Einführung keine sofortige vollständige Datenmigration erzwingt.
5. Als Admin möchte ich neue Projekte nur mit gesetzter Abrechnungsart speichern können, damit keine neuen Klassifizierungslücken entstehen.
6. Als Admin möchte ich bestehende Projekte beim Bearbeiten nur mit gesetzter Abrechnungsart speichern können, damit Altdaten schrittweise bereinigt werden.
7. Als Admin möchte ich nicht klassifizierte Altdaten im Report sehen, damit fehlende Projektklassifizierungen auffallen.
8. Als Admin möchte ich einen eigenen Report „Abrechnungsprüfung“ nutzen, damit diese Kontrolle nicht in bestehenden Reports versteckt ist.
9. Als Admin möchte ich den Report unter „Berichte“ finden, damit er in die bestehende Kimai-Navigation passt.
10. Als Admin möchte ich den Report nur mit Admin-Berechtigung öffnen können, damit abrechnungsrelevante Mitarbeiterdaten geschützt bleiben.
11. Als Admin möchte ich Monat und Jahr auswählen können, damit ich die Prüfung passend zum Abrechnungsmonat durchführen kann.
12. Als Admin möchte ich standardmäßig einen Monatsreport sehen, damit die Bedienung zur monatlichen Abrechnung passt.
13. Als Admin möchte ich pro aktivem Benutzer eine Tabellenzeile sehen, damit ich auch Mitarbeiter mit 0 Stunden im Monat erkenne.
14. Als Admin möchte ich deaktivierte Benutzer sehen, wenn sie im gewählten Monat relevante Zeiten gebucht haben, damit historische Abrechnungen vollständig bleiben.
15. Als Admin möchte ich Benutzer alphabetisch sortiert sehen, damit die Tabelle stabil und einfach kontrollierbar ist.
16. Als Admin möchte ich pro Benutzer die Spalte „Nach Aufwand“ sehen, damit ich die für Redmine relevante Stundenmenge prüfen kann.
17. Als Admin möchte ich pro Benutzer die Spalte „Pauschal“ sehen, damit pauschale Projektstunden transparent, aber vom Redmine-Abgleich getrennt sind.
18. Als Admin möchte ich pro Benutzer die Spalte „Nicht klassifiziert“ sehen, damit ungeklärte Projektstunden nicht verschwinden.
19. Als Admin möchte ich pro Benutzer eine Gesamtspalte sehen, damit ich die Summe aller verrechenbaren Stunden nachvollziehen kann.
20. Als Admin möchte ich eine Summenzeile am Tabellenende sehen, damit ich den Monatsgesamtwert schnell mit externen Zahlen vergleichen kann.
21. Als Admin möchte ich nur verrechenbare Zeitbuchungen zählen, damit der Report zur Abrechnungsprüfung passt.
22. Als Admin möchte ich nur abgeschlossene Zeitbuchungen zählen, damit laufende Timer keine instabilen Abrechnungswerte erzeugen.
23. Als Admin möchte ich Buchungen nach Startdatum dem Monat zuordnen, damit die Monatslogik einfach und nachvollziehbar bleibt.
24. Als Admin möchte ich die gebuchte Dauer summieren, damit der Report Stunden und nicht Geldbeträge oder Exportstatus prüft.
25. Als Admin möchte ich Stunden als Dezimalstunden mit zwei Nachkommastellen sehen, damit die Werte leicht mit Abrechnungs- und Redmine-Summen vergleichbar sind.
26. Als Admin möchte ich unbekannte oder gelöschte Benutzer nicht verlieren, damit alle relevanten Stunden im Report erscheinen.
27. Als Admin möchte ich unbekannte Benutzer unter „Unbekannter Benutzer“ sehen, damit nicht zuordenbare Daten sichtbar bleiben.
28. Als Admin möchte ich Pauschalprojekte nicht in den Redmine-relevanten Wert mischen, damit keine falschen Soll-Ist-Vergleiche entstehen.
29. Als Admin möchte ich Aufwandsstunden nicht projektweise aufklappen müssen, damit V1 bewusst einfach bleibt.
30. Als Admin möchte ich den Report ohne Redmine- oder CRM-API nutzen können, damit die erste Version schnell und risikoarm umsetzbar ist.

## Implementation Decisions

- Die Lösung bleibt bewusst klein und folgt dem Prinzip „Reuse first“: bestehende Kimai-Entitäten, Formulare, Report-Controller, Repositories, Templates und Berechtigungsmechanismen werden erweitert statt durch parallele Strukturen ersetzt.
- Das Projekt erhält ein persistiertes Feld für die Abrechnungsart. Die Feldwerte sind `flat`, `atcost` und `null` für Altdaten.
- Für die Datenbank wird eine Migration vorgesehen, die das Feld nullable anlegt. Bestehende Projekte bleiben dadurch technisch gültig und erscheinen bis zur Nachpflege als nicht klassifiziert.
- Die fachliche Validierung erzwingt beim Speichern über das Projektformular, dass eine Abrechnungsart gesetzt ist. Das gilt für neue Projekte und für bestehende Projekte, sobald sie bearbeitet werden.
- Die UI zeigt deutsche Labels: „Pauschal“, „Nach Aufwand“ und im Report „Nicht klassifiziert“.
- Für das Projektformular wird ein Auswahlfeld verwendet, kein Freitextfeld.
- Der neue Report wird als eigener Reporting-Controller bzw. Reporting-Modul umgesetzt und in die bestehende Reporting-Übersicht eingebunden.
- Die Berechtigung für V1 ist Admin-orientiert. Technisch soll dafür die bestehende Rollen-/Permission-Struktur von Kimai genutzt werden; der Report darf nicht für normale Benutzer sichtbar sein.
- Die Report-Query summiert Timesheet-Dauer gruppiert nach Benutzer und Projekt-Abrechnungsart.
- Es zählen nur Timesheets mit `billable = true`.
- Es zählen nur Timesheets mit gesetztem Ende; laufende Buchungen werden ignoriert.
- Die Monatsfilterung nutzt das Startdatum der Zeitbuchung.
- Zeitbuchungen über Monatsgrenzen werden vollständig dem Monat des Startdatums zugerechnet.
- Aktive Benutzer werden immer in die Tabelle aufgenommen, auch wenn sie im Monat 0 relevante Stunden haben.
- Deaktivierte Benutzer werden nur aufgenommen, wenn sie im Monat passende Buchungen haben.
- Die Sortierung erfolgt alphabetisch nach Benutzername.
- Die Darstellung erfolgt in Dezimalstunden mit zwei Nachkommastellen.
- Für die Report-Berechnung sollte ein kleines, testbares Reporting-Modul bzw. eine Query-/Result-Klasse entstehen. Dieses Modul kapselt die Summenlogik und liefert dem Controller bereits vorbereitete Zeilen und Totals.
- Templates sollen nur darstellen und keine fachliche Gruppierungslogik enthalten.
- Übersetzungen werden in den bestehenden Kimai-Übersetzungsdateien ergänzt, insbesondere für Projektfeld, Auswahlwerte und Reporttitel.
- API-Erweiterungen für Projekte sind nicht primäres Ziel von V1, sollten aber bei einer persistenten Projekt-Eigenschaft bewusst geprüft werden, damit Formular/API-Verhalten nicht ungewollt auseinanderläuft.
- Exporter-/Serializer-Erweiterungen sind nicht Kern von V1, sollten aber als Folgeentscheidung geprüft werden, falls Projektlisten oder APIs die neue Klassifizierung sichtbar machen sollen.

## Testing Decisions

- Tests sollen externes Verhalten prüfen, nicht interne Query-Details. Entscheidend ist, welche Stunden der Report für konkrete Testdaten ausgibt.
- Die Berechnungslogik des Reports soll isoliert testbar sein. Ein guter Test erzeugt mehrere Benutzer, Projekte mit `flat`, `atcost` und `null`, verrechenbare und nicht verrechenbare Zeiten sowie laufende Einträge und prüft die resultierenden Summen.
- Es soll getestet werden, dass nur `billable = true` gezählt wird.
- Es soll getestet werden, dass laufende Zeitbuchungen ohne Endzeit nicht gezählt werden.
- Es soll getestet werden, dass die Monatszuordnung nach Startdatum erfolgt.
- Es soll getestet werden, dass nicht klassifizierte Projekte in der Spalte „Nicht klassifiziert“ landen.
- Es soll getestet werden, dass aktive Benutzer ohne Stunden mit 0-Werten erscheinen.
- Es soll getestet werden, dass deaktivierte Benutzer nur erscheinen, wenn sie relevante Stunden im Monat haben.
- Es soll getestet werden, dass Summenzeilen bzw. Gesamtwerte korrekt berechnet werden.
- Für das Projektformular soll getestet werden, dass neue und bearbeitete Projekte eine Abrechnungsart benötigen.
- Für bestehende Altdaten soll getestet werden, dass `null` in der Datenbank möglich bleibt und im Report korrekt klassifiziert wird.
- Für den Controller soll ein Integrationstest prüfen, dass der Report für Admins erreichbar ist.
- Für Berechtigungen soll ein Integrationstest prüfen, dass normale Benutzer den Admin-Report nicht sehen bzw. nicht öffnen dürfen.
- Prior Art im Codebase: bestehende Reporting-Controller-Tests, ReportingService-Tests, ProjectEditForm-Tests und TimesheetRepository-/Statistiktests dienen als Orientierung.
- Vor Abschluss der Implementierung sollen mindestens passende gezielte PHPUnit-Tests laufen. Bei größerem Eingriff zusätzlich `composer codestyle`, `composer phpstan` und relevante Integrationstests.

## Out of Scope

- Kein automatischer Redmine-Abgleich.
- Keine CRM-API-Anbindung.
- Kein CSV-/Excel-Export für V1.
- Keine Ticketnummern oder Auftragslinks an Zeitbuchungen.
- Keine Projekt-Detailansicht innerhalb des Reports.
- Keine Zuordnung einzelner Kimai-Zeitbuchungen zu Redmine-Tickets.
- Keine Prüfung, ob Redmine- oder CRM-Stunden identisch sind.
- Keine Änderung der Abrechnungslogik, Preise, Raten oder Rechnungsstellung.
- Keine Auswertung nach Kunde oder Projekt in V1.
- Keine anteilige Aufteilung von Buchungen über Monatsgrenzen.

## Further Notes

- Der Report ist eine erste Tracer-Bullet-Version für die Abrechnungsprüfung. Er schafft eine belastbare interne Kimai-Summe für manuelle Vergleiche mit Redmine/CRM.
- Die sichtbare Spalte „Nicht klassifiziert“ ist bewusst Teil der Lösung, damit Altdaten nach und nach bereinigt werden können.
- Eine spätere Version kann auf dieser Basis CSV-Export, Redmine-Projekt- oder Ticket-Zuordnungen, CRM-Auftragslinks und automatische Abweichungsprüfungen ergänzen.
- Die Umsetzung soll bestehende Kimai-Konventionen respektieren: kleine fokussierte Änderungen, vorhandene Reporting-Strukturen verwenden, Fachlogik in Services/Queries kapseln und Templates schlank halten.
