---
title: Report-Summen pro Benutzer berechnen
type: AFK
status: todo
---

## Parent

`docs/prd/billing-classification-report.md`

## What to build

Der Report berechnet für einen ausgewählten Monat pro Benutzer die verrechenbaren, abgeschlossenen Stunden gruppiert nach Projekt-Abrechnungsart. Die Berechnung ist in einem kleinen testbaren Modul gekapselt und liefert vorbereitete Zeilen inklusive Gesamtwerten.

## Acceptance criteria

- [ ] Es zählen nur Zeitbuchungen mit `billable = true`.
- [ ] Es zählen nur abgeschlossene Zeitbuchungen mit gesetzter Endzeit.
- [ ] Die Monatszuordnung erfolgt nach Startdatum der Buchung.
- [ ] Buchungen über Monatsgrenzen werden vollständig dem Startmonat zugerechnet.
- [ ] Stunden auf `atcost`-Projekten landen in „Nach Aufwand“.
- [ ] Stunden auf `flat`-Projekten landen in „Pauschal“.
- [ ] Stunden auf Projekten ohne Abrechnungsart landen in „Nicht klassifiziert“.
- [ ] Aktive Benutzer erscheinen immer, auch mit 0 Stunden.
- [ ] Deaktivierte Benutzer erscheinen nur, wenn sie im Monat passende Buchungen haben.
- [ ] Unbekannte oder nicht mehr zuordenbare Benutzerstunden verschwinden nicht und werden als „Unbekannter Benutzer“ berücksichtigt, falls technisch möglich.
- [ ] Unit-/Repository-/Service-Tests decken die Klassifizierungs-, Monats- und Benutzerregeln ab.

## Blocked by

- `docs/prd/billing-classification-report/tasks/001-store-project-billing-classification.md`
- `docs/prd/billing-classification-report/tasks/002-add-minimal-admin-billing-report.md`
