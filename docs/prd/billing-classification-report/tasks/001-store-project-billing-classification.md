---
title: Projekt-Abrechnungsart speichern
type: AFK
status: todo
---

## Parent

`docs/prd/billing-classification-report.md`

## What to build

Projekte können eine Abrechnungsart speichern und im Projektformular bearbeiten. Neue und bearbeitete Projekte müssen eine Abrechnungsart setzen, während bestehende Altdaten ohne Wert weiterhin technisch gültig bleiben.

## Acceptance criteria

- [ ] Projekte haben ein persistiertes nullable Feld für die Abrechnungsart.
- [ ] Erlaubte technische Werte sind `flat`, `atcost` und `null` für Altdaten.
- [ ] Das Projektformular zeigt ein Auswahlfeld „Abrechnungsart“ mit „Pauschal“ und „Nach Aufwand“.
- [ ] Neue Projekte können ohne Abrechnungsart nicht gespeichert werden.
- [ ] Bearbeitete bestehende Projekte können ohne Abrechnungsart nicht gespeichert werden.
- [ ] Bestehende Projekte mit `null` bleiben durch die Migration gültig.
- [ ] Formular-/Entity-Tests decken gültige Werte, fehlenden Wert und Altdaten-Kompatibilität ab.

## Blocked by

None - can start immediately
