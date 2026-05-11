---
title: Minimalen Admin-Report sichtbar machen
type: AFK
status: todo
---

## Parent

`docs/prd/billing-classification-report.md`

## What to build

Ein neuer Report „Abrechnungsprüfung“ ist für Admins im Reporting-Bereich erreichbar. Der Report bietet einen Monats-/Jahresfilter und zeigt zunächst eine stabile, leere oder placeholder-fähige Tabellenstruktur, ohne bereits die finale Summenlogik liefern zu müssen.

## Acceptance criteria

- [ ] Der Report erscheint unter „Berichte“ als „Abrechnungsprüfung“.
- [ ] Nur Admins können den Report sehen und öffnen.
- [ ] Normale Benutzer erhalten keinen Zugriff auf den Report.
- [ ] Der Report hat einen Monats-/Jahresfilter und sinnvolle Defaults für den aktuellen Monat.
- [ ] Die Seite rendert ohne Fehler mit Tabellenkopf für Benutzer, Nach Aufwand, Pauschal, Nicht klassifiziert und Gesamt.
- [ ] Controller-/Integrationstests prüfen Admin-Zugriff und fehlenden Zugriff für normale Benutzer.

## Blocked by

- `docs/prd/billing-classification-report/tasks/001-store-project-billing-classification.md`
