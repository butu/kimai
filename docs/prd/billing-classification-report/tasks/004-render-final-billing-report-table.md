---
title: Report-Tabelle final darstellen
type: AFK
status: todo
---

## Parent

`docs/prd/billing-classification-report.md`

## What to build

Die Abrechnungsprüfung zeigt die berechneten Werte als finale Admin-Tabelle mit deutschen Labels, Dezimalstunden, alphabetisch sortierten Benutzern und Summenzeile.

## Acceptance criteria

- [ ] Die Tabelle zeigt die Spalten Benutzer, Nach Aufwand, Pauschal, Nicht klassifiziert und Gesamt.
- [ ] Benutzer sind alphabetisch sortiert.
- [ ] Stunden werden als Dezimalstunden mit zwei Nachkommastellen dargestellt.
- [ ] Benutzer ohne Stunden zeigen `0,00 h` in den passenden Spalten.
- [ ] Jede Benutzerzeile zeigt einen korrekten Gesamtwert.
- [ ] Eine Summenzeile am Tabellenende zeigt korrekte Spaltensummen.
- [ ] Templates enthalten nur Darstellungslogik; fachliche Gruppierung bleibt im Reporting-Modul.
- [ ] Integrationstest oder Snapshot-nahe Prüfung stellt sicher, dass zentrale Labels und Summen im HTML erscheinen.

## Blocked by

- `docs/prd/billing-classification-report/tasks/003-calculate-user-billing-report-sums.md`
